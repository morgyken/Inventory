<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Inventory\Library;

use Carbon\Carbon;
use Ignite\Core\Entities\Notification;
use Ignite\Evaluation\Entities\Dispensing;
use Ignite\Evaluation\Entities\Visit;
use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\InsuranceInvoice;
use Ignite\Inventory\Entities\Customer;
use Ignite\Inventory\Entities\InternalOrder;
use Ignite\Inventory\Entities\InternalOrderDetails;
use Ignite\Inventory\Entities\InternalOrderDispatch;
use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\InventoryCategories;
use Ignite\Inventory\Entities\InventoryDispensing;
use Ignite\Inventory\Entities\InventoryInsuranceDetails;
use Ignite\Inventory\Entities\InventoryInvoice;
use Ignite\Inventory\Entities\InventoryPayments;
use Ignite\Inventory\Entities\InventoryPaymentTerms;
use Ignite\Inventory\Entities\InventoryProductDiscount;
use Ignite\Inventory\Entities\InventoryProductMarkup;
use Ignite\Inventory\Entities\InventoryProductPrice;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\InventoryPurchaseOrderDetails;
use Ignite\Inventory\Entities\InventoryPurchaseOrders;
use Ignite\Inventory\Entities\InventorySalesReturn;
use Ignite\Inventory\Entities\InventoryStock;
use Ignite\Inventory\Entities\InventoryStockAdjustment;
use Ignite\Inventory\Entities\InventorySupplier;
use Ignite\Inventory\Entities\InventoryTaxCategory;
use Ignite\Inventory\Entities\InventoryUnits;
use Ignite\Inventory\Entities\OrderToCollabmed;
use Ignite\Inventory\Entities\Requisition;
use Ignite\Inventory\Entities\RequisitionDetails;
use Ignite\Inventory\Events\MarkupWasAdjusted;
use Ignite\Inventory\Repositories\InventoryRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Description of InventoryFunctions
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class InventoryFunctions implements InventoryRepository
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * InventoryFunctions constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Add a supplier to the database
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public function add_supplier($id = null)
    {
        $supplier = InventorySupplier::findOrNew($id);
        $supplier->name = ucfirst($this->request->name);
        $supplier->address = $this->request->address;
        $supplier->telephone = $this->request->telephone;
        $supplier->mobile = $this->request->mobile;
        $supplier->post_code = $this->request->post_code;
        $supplier->email = $this->request->email;
        $supplier->building = $this->request->building;
        $supplier->fax = $this->request->fax;
        $supplier->street = $this->request->street;
        $supplier->town = $this->request->town;
        return $supplier->save();
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public function add_product_category($id = null)
    {
        try {
            $category = InventoryCategories::findOrNew($id);
            $category->name = ucfirst($this->request->name);
            $category->parent = $this->request->parent_category;
            if ($this->request->credit_markup >= 0) {
                $category->credit_markup = $this->request->credit_markup;
            }
            if ($this->request->cash_markup >= 0) {
                $category->cash_markup = $this->request->cash_markup;
            }
            $result = $category->save();
            return $result;
        } catch (\Exception $e) {
            flash()->error($e->errorInfo['2']);
        }
    }

    /**
     * Add tax category
     * @param Request $request
     * @param int|null $id
     * @return mixed
     */
    public function add_tax_category($id = null)
    {
        $category = InventoryTaxCategory::findOrNew($id);
        $category->name = ucfirst($this->request->name);
        $category->rate = $this->request->rate;
        return $category->save();
    }

    /**
     * Add to database /or update
     * @param Request $request
     * @param int|null $id
     * @return mixed
     */
    public function add_unit_of_measure($id = null)
    {
        $unit = InventoryUnits::findOrNew($id);
        $unit->name = ucfirst($this->request->name);
        $unit->description = $this->request->description;
        return $unit->save();
    }

    /**
     * @param int|null $id
     * @return bool
     * @throws \Exception
     */
    public function add_product($id = null)
    {
        DB::transaction(function () use ($id) {
            /** @var InventoryProducts $product */
            $product = InventoryProducts::firstOrNew(['id' => $id]);
            $product->name = ucfirst($this->request->name);
            $product->description = $this->request->description;
            $product->category = $this->request->category;
            $product->unit = $this->request->unit;
            $product->tax_category = $this->request->tax;
            $product->reorder_level = $this->request->reorder_level;
            $product->formulation = $this->request->formulation;
            $product->label_type = $this->request->label_type;
            $product->strength = $this->request->strength;
            if (\Schema::hasColumn('inventory_products', 'consumable')) {
                $product->consumable = $this->request->has('consumable');
            }
            $product->save();
        });
        return true;
    }

    /**
     * Add pament term
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public function add_payment_term($id = null)
    {
        $term = InventoryPaymentTerms::findOrNew($id);
        $term->terms = $this->request->terms;
        $term->description = $this->request->description;
        return $term->save();
    }

    /**
     * Create an LPO
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public function add_new_order($id = null)
    {
        DB::transaction(function () use ($id) {
            $order = new InventoryPurchaseOrders();
            $order->supplier = $this->request->supplier;
            $order->deliver_date = new \Date($this->request->delivery_date);
            $order->payment_terms = $this->request->payment_terms;
            $order->payment_mode = $this->request->payment_mode;
            $order->user = $this->request->user()->id;
            $order->save();

            if (isset($this->request->req)) {
                $this->CancelRequisition($this->request->req);
            }

            session(['last_order' => $order->id]);
            $stack = self::order_item_stack(array_keys($this->request->all()));
            foreach ($stack as $index) {
                $item = 'item' . $index;
                $price = 'price' . $index;
                $quantity = 'qty' . $index;
                $details = new InventoryPurchaseOrderDetails();
                if ($this->request->has($item) && $this->request->has($price) && $this->request->has($quantity)) {
                    $details->order = $order->id;
                    $details->product = $this->request->$item;
                    $details->price = $this->request->$price;
                    $details->quantity = $this->request->$quantity;
                    $details->save();
                }
            }
        });
        return true;
    }

    /**
     * Build an index of items in dynamic LPO
     * @param $keys
     * @return array
     */
    private function order_item_stack($keys)
    {
        $stack = [];
        foreach ($keys as $one) {
            if (substr($one, 0, 4) == 'item') {
                $stack[] = substr($one, 4);
            }
        }
        return $stack;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function saveProdPrice()
    {
        foreach ($this->request->products as $index => $product_id) {
            $product_price = InventoryProductPrice::firstOrNew(['product' => $product_id]);
            $product_price->product = $this->request->products[$index];
            $product_price->price = $this->request->prices[$index];
            $product_price->save();
        }
        return 'saved';
    }

    public function updateProdPrice()
    {
        $update = $this->request->data;
        foreach ($update as $item) {
            $price = InventoryProductPrice::firstOrNew(['product' => $item['product']]);
            $price->price = $item['cash'];
            $price->ins_price = $item['insurance'];
            $price->save();
        }
        return ['saved' => true];
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function saveProdDiscount()
    {
        foreach ($this->request->products as $index => $product_id) {
            $product_discount = InventoryProductDiscount::firstOrNew(['product' => $product_id]);
            $product_discount->product = $this->request->products[$index];
            $product_discount->discount = $this->request->discounts[$index];
            $product_discount->end_date = new \Date($this->request->end_dates[$index]);
            $product_discount->save();
        }
        return 'saved';
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function markup()
    {
        foreach ($this->request->product as $index => $product_id) {
            $markup = InventoryProductMarkup::firstOrNew(['product' => $product_id]);
            $markup->product = $this->request->product[$index];
            $markup->markup = $this->request->markup[$index];
            $markup->save();
        }
        return 'saved';
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function saveCatPrice()
    {
        foreach ($this->request->cats as $index => $cat_id) {
            $cat_price = InventoryCategoryPrice::firstOrNew(['category' => $cat_id]);
            $cat_price->category = $this->request->cats[$index];
            $cat_price->price = $this->request->prices[$index];
            $cat_price->save();
        }
        return 'saved';
    }

    /**
     * @param $id
     * @return bool
     */
    public function approveLPO($id)
    {
        $this_LPO = InventoryPurchaseOrders::find($id);
        $this_LPO->status = 1;
        return $this_LPO->save();
    }

    /** Record sales
     * @todo Add payment amount to product sales if necessary
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public function record_sales($id = null)
    {
        \DB::beginTransaction();
        try {
            $patient = $this->request->patient;
            $receipt = config('system.receipt_prefix') . time();
            $stack = $this->order_item_stack(array_keys($this->request->all()));
            $sales = new InventoryBatchProductSales;
            $sales->user = $this->request->user()->id;
            $sales->patient = $patient;

            if (isset($this->request->is_shop)) {
                $sales->shop = true;
            }

            $visit = Visit::wherePatient($patient)
                ->get()
                ->last();

            $sales->visit = $visit['id'];


            if (isset($this->request->scheme)) {
                //save scheme
                $sales->insurance = $this->request->scheme;
            }

            //$sales->payment_mode = $this->request->payment_mode;
            $sales->receipt = strtoupper($receipt);
            //$sales->paid = ($sales->payment_mode != 'insurance');
            $sales->save();

            if ($sales->insurance > 0) {
                $this->save_insurance_invoice($sales->id, $sales->receipt, $sales->created_at);
            }

            foreach ($stack as $index) {
                $item = 'item' . $index;
                $price = 'price' . $index;
                $batch = 'batch' . $index;
                $quantity = 'qty' . $index;
                $discount = 'dis' . $index;
                if ($this->request->has($item) && $this->request->has($price) && $this->request->has($quantity)) {
                    $sale = new InventoryDispensing;
                    $sale->batch = $sales->id;
                    $sale->product = $this->request->$item;
                    $sale->price = $this->request->$price;
                    $sale->quantity = $this->request->$quantity;
                    $sale->discount = $this->request->$discount;
//move items in queue
                    $stock = InventoryStock::where('product', '=', $this->request->$item)->first();
                    if ($stock->quantity < $this->request->$quantity) {
                        \DB::rollback();
                        flash()->error('An item you tried to sell is unfortunately out of stock...');
                        redirect()->back();
                    }
                    if ($this->request->$batch > 0) {
                        $this->update_queue($sale->product, $this->request->$batch, $sale->quantity);
                    }
                    $sale->save();
                }
            }
            $this->take_products($sales); //notify stock
            //$this->record_payments($receipt, $this->request->payment_mode);
            session(['receipt_id' => $sales->id]);
            if (isset($this->request->pharmacy)) {
                //save dispense
                $this->saveEvaluationDispense($this->request, $sales->id);
            }
            \DB::commit();
            return true;
        } catch (\Exception $e) {
            \DB::rollback();
            flash()->error("Something went wrong<br/>1. Be sure you selected an existing patient, select \"Walkin Patient\" for random client <br/>"
                . "<i>If 'walkin patient' account does not exist, it can be created at RECEPTION </i>"
                . " <br>2. Trying to sell a product/drug that is out of stock will throw this exception"
                . "<br/><i>Go to Inventory>>Products>>Items in Store to adjust item stock, or Inventory>>Purchases>>Receive Goods</i>");
            //return back();
            //flash()->warning("Ooops! something went wrong... Be sure any product added to cart is in the system (<a target='blank' href='/inventory/goods/receive'>was received</a>)");
        }//Catch
    }

    public static function saveEvaluationDispense($request, $batch)
    {
        $sale = InventoryBatchProductSales::find($batch);
        $sale->paid = false;
        $sale->update();

        $dispense = new Dispensing();
        $dispense->visit = $request->visit_id;
        $dispense->user = \Auth::user()->id;
        $dispense->batch = $batch;

        self::saveEvaluationPayment($request, $sale->receipt);
        return $dispense->save();
    }

    public static function saveEvaluationPayment($request, $rcpt)
    {
        $payment = new EvaluationPayments();
        $payment->receipt = $rcpt;
        $payment->patient = $request->patient_id;
        $payment->amount = $request->amount;
        $payment->user = \Auth::user()->id;
        $payment->save();
    }

    /**
     * @param Request $request
     * @param $receipt
     * @param $payment_mode
     * @return bool
     */
    private function record_payments($receipt, $payment_mode)
    {
        $pay = new InventoryPayments;
        $pay->receipt = strtoupper($receipt); //$receipt;
//user and patient
        $pay->user = $this->request->user()->id;

        if ($payment_mode == 'cash') {
//cash
            $pay->CashAmount = $this->request->amount;
        } elseif ($payment_mode == 'mpesa') {
//mpesa
            $pay->MpesaAmount = $this->request->amount;
            $pay->MpesaReference = strtoupper($this->request->MpesaRef);
        } elseif ($payment_mode == 'cheque') {
//cheque
            $pay->ChequeName = strtoupper($this->request->Ac_holder_name);
            $pay->ChequeDate = $this->request->ChequeDate;
            $pay->ChequeAmount = $this->request->amount;
            $pay->ChequeName = $this->request->ChequeNumber;
            $pay->ChequeBank = $this->request->Bank;
            $pay->ChequeBankBranch = $this->request->Branch;
        } elseif ($payment_mode == 'card') {
//card
            $pay->CardName = $this->request->CardNames;
            $pay->CardType = $this->request->CardType;
            $pay->CardAmount = $this->request->amount;
            $pay->CardSecurity = $this->request->security_code;
            $pay->CardExpiry = $this->request->expiry_month + "/" + $this->request->expiry_year;
            $pay->CardNumber = $this->request->CardNumber;
        } elseif ($payment_mode == 'insurance') {
            try {//payment
                $pay->scheme = $this->request->scheme;
                $pay->InsuranceAmount = $this->request->amount;
                $customer = $this->request->customer_id; //Client
                $details = InventoryInsuranceDetails::where('customer', '=', $customer)
                    ->where('policy_no', '=', $this->request->policy)
                    ->first(); //Credit Details
                $sale = InventoryBatchProductSales::query()->where('receipt', '=', $receipt)->first(); //update sale
                $sale->customer = $customer;
                $sale->insurance = $details->id;
                $sale->save();

                //save invoice details
                $this->save_insurance_invoice($sale->id, $sale->receipt, $sale->created_at);
            } catch (\Exception $e) {
                flash()->info('There was a problem processing your request... kindly try again');
                redirect()->back();
            }
        } else {
//
        }

        return $pay->save();
    }

    /**
     * @param save_insurance_invoice $sale
     */
    private function save_insurance_invoice($id, $receipt, $date)
    {
        $inv = new InsuranceInvoice;
        $inv->invoice_no = $receipt;
        $inv->receipt = $id;
        $inv->status = 1;
        $inv->invoice_date = new \Date($date);
        $inv->save();
    }

    /**
     * @param InventoryBatchProductSales $sale
     */
    private function take_products(InventoryBatchProductSales $sale)
    {
        foreach ($sale->goodies as $vending) {
            $adj = new InventoryStockAdjustment;
            $adj->quantity = $vending->quantity;
            $adj->type = 'sales';
            $adj->method = '-';
            $adj->user = \Auth::user()->id;
            $adj->product = $vending->product;
            $adj->opening_qty = self::openingStock($vending->product);
            $adj->reason = 'Product sales Receipt #' . $vending->receipt_no;
            $adj->save();
            $this->adjust_stock($adj);
        }
    }

    public function take_dispensed_products($dispense)
    {
        $vending = $dispense;
        $adj = new InventoryStockAdjustment;
        $adj->quantity = $vending->quantity;
        $adj->type = 'pharmacy';
        $adj->method = '-';
        $adj->user = \Auth::user()->id;
        $adj->product = $vending->product;
        $adj->opening_qty = $this->openingStock($vending->product);
        $adj->reason = 'Pharmacy Dispensing' . $vending->batch;
        $adj->save();
        $this->adjust_stock($adj);
    }

    /**
     * @todo Rename to set product price
     * @param InventoryBatch $incoming
     * @return bool
     */
    public function apply_markup(InventoryBatch $incoming)
    {
        DB::transaction(function () use ($incoming) {
            foreach ($incoming->products as $item) {
                $markup = $item->products->categories->cash_markup;
                $price = new InventoryProductPrice(); //::firstOrNew(['product' => $item->product]);
                $price->product = $item->product;
                $price->price = $item->unit_cost;
                $price->batch = $incoming->id;
                $price->selling = null; // empty($markup) ? 0 : ($markup + 100) / 100 * $price->price;
                $price->save();
                $this->enQueueProductBatch($price->batch, $price->product);
            }
        });
        return true;
    }

    public function enQueueProductBatch($batch, $product)
    {
        $in_q = InventoryBatchPurchases::query()
            ->where('product', '=', $product)
            ->where('active', '=', TRUE)
            ->first();
        if (isset($in_q->id)) {
            $q = InventoryBatchPurchases::query()
                ->where('product', '=', $product)
                ->where('batch', '=', $batch)
                ->first();
            $q->active = FALSE;
        } else {
            $q = InventoryBatchPurchases::query()
                ->where('product', '=', $product)
                ->where('batch', '=', $batch)
                ->first();
            $q->active = TRUE;
        }
        return $q->save();
    }

    public function deQueueProductBatch($batch, $product)
    {
        $q = InventoryBatchPurchases::query()
            ->where('product', '=', $product)
            ->where('batch', '=', $batch)
            ->first();
        $q->active = FALSE;
        return $q->save();
    }

    public function activateQueue($batch, $product)
    {
        $q = InventoryBatchPurchases::query()
            ->where('product', '=', $product)
            ->where('batch', '=', $batch)
            ->first();
        $q->active = TRUE;
        return $q->save();
    }

    public function update_queue($product, $batch, $qty)
    {
        $b_purchase = InventoryBatchPurchases::where('product', '=', $product)
            ->where('batch', '=', $batch)
            ->first();
        $batch_qty = $b_purchase->quantity * $b_purchase->package_size;
        $qty_sold = $b_purchase->qty_sold;
        $batch_items_remaining = $batch_qty - $qty_sold;
        if ($qty > $batch_items_remaining) {
//Sell surplus in nextbatch
            $surplus = $qty - $batch_items_remaining;

            $next = InventoryBatchPurchases::whereProduct($b_purchase->product)
                ->where('id', '>', $b_purchase->id)
                ->first();

            $this->deQueueProductBatch($b_purchase->batch, $b_purchase->product);
            if (isset($next)) {
                $this->activateQueue($next->batch, $next->product);
                $next->qty_sold += $surplus;
                $next->save();
            }
            $b_purchase->qty_sold += $batch_items_remaining;
        } else {
            $b_purchase->qty_sold += $qty;
        }
        $b_purchase->save();
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function receive_goods_direct()
    {
        DB::transaction(function () {
            $stack = self::order_item_stack(array_keys($this->request->all()));
            $order = new InventoryBatch;
            $order->user = $this->request->user()->id;
            $order->amount = $this->request->amount;
            $order->supplier = $this->request->supplier;
            $order->save();
            foreach ($stack as $index) {
                $item = 'item' . $index;
                $price = 'price' . $index;
                $quantity = 'qty' . $index;
                $bonus = 'bonus' . $index;
                $discount = 'dis' . $index;
                $tax = 'tax' . $index;
                $expiry = 'expiry' . $index;
                $package = 'package' . $index;
                if ($this->request->has($item) && $this->request->has($price) && $this->request->has($quantity)) {
                    $details = new InventoryBatchPurchases;
                    $details->batch = $order->id;
                    $details->bonus = $this->request->$bonus;
                    $details->product = $this->request->$item;
                    if ($this->request->$package > 0) {
                        $details->unit_cost = $this->request->$price / $this->request->$package;
                    } else {
                        $details->unit_cost = $this->request->$price;
                    }
                    $details->quantity = $this->request->$quantity;
                    $details->discount = $this->request->$discount;
                    $details->tax = $this->request->$tax;
                    $this->request->$expiry ? $details->expiry_date = str_replace('-', '/', $this->request->$expiry) : $details->expiry_date = NULL;
                    $details->package_size = $this->request->$package;
                    $details->save();
                }
            }
//$job = (new StockUpdate($order, true))->onQueue('stock');
//dispatch($job);
            $this->update_stock_from_lpo($order, true);
            session(['last_receive' => $order->id]);
        });

        return true;
    }

    /**
     * Receive products from lpo
     * @param Request $request
     * @return bool
     */
    public function receive_from_lpo()
    {
        DB::transaction(function () {
            $stack = self::order_item_stack(array_keys($this->request->all()));
            $order = new InventoryBatch;
            $order->order = $this->request->lpo;
            $order->user = $this->request->user()->id;
            $order->amount = $this->request->amount;
            $order->supplier = $this->request->supplier;
            $order->save();
            foreach ($stack as $index) {
                $item = 'item' . $index;
                $price = 'price' . $index;
                $quantity = 'qty' . $index;
                $bonus = 'bonus' . $index;
                $discount = 'dis' . $index;
                $tax = 'tax' . $index;
                $expiry = 'expiry' . $index;
                $package = 'package' . $index;
                if ($this->request->has($item) && $this->request->has($price) && $this->request->has($quantity)) {
                    $details = new InventoryBatchPurchases;
                    $details->batch = $order->id;
                    $details->bonus = $this->request->$bonus;
                    $details->product = $this->request->$item;
                    $details->unit_cost = $this->request->$price / $this->request->$package;
                    $details->quantity = $this->request->$quantity;
                    $details->discount = $this->request->$discount;
                    $details->tax = $this->request->$tax;
                    $details->expiry_date = $this->request->$expiry ? $details->expiry_date = str_replace('-', '/', $this->request->$expiry) : $details->expiry_date = NULL;
                    $details->package_size = $this->request->$package;
                    $details->save();
                }
            }
            $lpo = $order->lpo;
            $lpo->status = 3;
            $lpo->save();
            /* $job = (new StockUpdate($order))->onQueue('stock');
              dispatch($job); */
            $this->update_stock_from_lpo($order);
            session(['last_receive' => $order->id]);
        });

        return true;
    }

    /**
     * @param InventoryBatch $batch
     * @param bool $direct
     * @return bool
     */
    public function update_stock_from_lpo(InventoryBatch $batch, $direct = false)
    {
        DB::transaction(function () use ($batch, $direct) {
            foreach ($batch->products as $product) {
                $to_add = $product->package_size * $product->quantity + $product->bonus;
                $adj = new InventoryStockAdjustment;
                $adj->quantity = $to_add;
                $adj->user = \Auth::user()->id;
                $adj->method = '+';
                $adj->type = 'purchase';
                if ($direct) {
                    $adj->reason = "Received goods directly from LPO  Supplier - " . $batch->suppliers->name;
                } else {
                    $adj->reason = "Received goods from LPO #" . $batch->lpo->id . ' Supplier - ' . $batch->lpo->suppliers->name;
                }
                $adj->product = $product->product;
                $adj->opening_qty = self::openingStock($product->product);
                $adj->save();
                $this->adjust_stock($adj);
            }
        });
        event(new MarkupWasAdjusted($batch));
        return true;
    }

    /**
     * @param InventoryStockAdjustment $adj
     * @return bool
     */
    public function adjust_stock(InventoryStockAdjustment $adj)
    {
        $stock = InventoryStock::firstOrNew(['product' => $adj->product]);
        $curr = $stock->quantity;
        if (empty($stock->quantity)) {
            $curr = 0;
        }
        $stock->quantity = ($adj->method == '+') ? $curr + $adj->quantity : $curr - $adj->quantity;
        $stock->save();
        $this->StockNotification($stock->quantity, $adj->product);
    }

    public function StockNotification($stock, $item)
    {
        $product = InventoryProducts::find($item);
        if (isset($product->reorder_level)) {
            if ($stock < $product->reorder_level) {
                $noti = new Notification;
                $noti->user_id = \Auth::user()->id;
                $noti->title = $product->name . ' stock running low';
                $noti->message = $product->name . '\'s stock gone below reorder level';
                $noti->icon_class = 'fa fa-bell';
                $noti->save();
            }
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function set_stock_value()
    {
        DB::transaction(function () {
            $id = $this->request->id;
            $curr = InventoryStock::firstOrNew(['product' => $id])->quantity;
            if (empty($curr)) {
                $curr = 0;
            }
            $adj = new InventoryStockAdjustment;
            $adj->product = $id;
            $adj->opening_qty = self::openingStock($id);
            $adj->quantity = abs($this->request->quantity - $curr);
            $adj->user = $this->request->user()->id;
            $adj->method = ($this->request->quantity >= $curr) ? '+' : '-';
            $adj->reason = $this->request->reason;
            $adj->type = 'manual';
            $adj->approved = 'no';
            $adj->save();
            $this->adjust_stock($adj);
        });
        return true;
    }

    public function openingStock($item)
    {
        $stock = InventoryStock::where('product', '=', $item)->first();
        if ($stock) {
            return $stock->quantity;
        } else {
            return 0;
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function sales_return()
    {
        DB::beginTransaction();
        try {
            $sreturn = new InventorySalesReturn;
            $sreturn->product = $this->request->product;
            $sreturn->receipt_no = $this->request->rcpt;
            $sreturn->quantity = $this->request->qty;
            if (!isset($this->request->trash)) {
                $sreturn->stocked = true;
            }
            $sreturn->reason = $this->request->reason;
            $sreturn->save(); //update stock
            $curr = InventoryStock::firstOrNew(['product' => $this->request->product])->quantity;
            if (empty($curr)) {
                $curr = 0;
            }

            if (!isset($this->request->trash)) {
                $adj = new InventoryStockAdjustment;
                $adj->product = $this->request->product;
                $adj->opening_qty = self::openingStock($this->request->product);
                $adj->quantity = $this->request->qty;
                $adj->user = $this->request->user()->id;
                $adj->method = '+';
                $adj->reason = 'sales seturn';
                //$adj->type = 'return';
                $adj->save();
                $this->adjust_stock($adj);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            flash()->info('Something went wrong, please try again');
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     */
    public function supplier_invoice()
    {
        $inv = new InventoryInvoice;
        $inv->creditor = $this->request->creditor;
        $inv->amount = $this->request->amount;
        $inv->grn = $this->request->grn;
        $inv->date = $this->request->date;
        $inv->due_date = $this->request->due_date;
        $inv->status = $this->request->status;
        $inv->description = $this->request->description;
        $inv->number = $this->request->number;
        $inv->save();
    }

    public function save_client()
    {
        try {
//Client information
            $client = new Customer();
            $client->first_name = $this->request->first_name_ins;
            $client->last_name = $this->request->last_name_ins;
            $client->date_of_birth = new \Date($this->request->dob_user);
            $client->email = $this->request->email_ins;
            $client->phone = $this->request->phone_ins;
            $client->save();
//Credit Details
            $details = new InventoryInsuranceDetails;
            $details->customer = $client->id;
            $details->insurance_company = $this->request->company;
            $details->credit_scheme = $this->request->scheme;
            $details->policy_no = $this->request->policy_number;
            $details->principal = $this->request->principal;
            $details->date_of_birth = new \Date($this->request->principal_dob);
            $details->relation = $this->request->principal_relationship;
            $details->save();
            return true;
        } catch (\Exception $exc) {
            flash('A problem occured while saving the data.. kindly try again');
            return redirect()->back();
        }
    }

    public function purge_client($id)
    {
        try {
            $client = Customer::find($id);
            $client->delete();
            return true;
        } catch (\Exception $e) {
            flash('A problem occured while executing your request.. kindly try again', 'success');
            return redirect()->back();
        }
    }

    public function SaveRequisition()
    {
        DB::transaction(function () {
            $stack = self::order_item_stack(array_keys($this->request->all()));
            $req = new Requisition;
            $req->user = \Auth::user()->id;
            $req->reason = $this->request->description;
            $req->save();
            foreach ($stack as $index) {
                $item = 'item' . $index;
                $quantity = 'qty' . $index;
                $details = new RequisitionDetails();
                $details->requisition = $req->id;
                $details->item = $this->request->$item;
                $details->quantity = $this->request->$quantity;
                $details->save();
            }
        });

        return true;
    }

    public function CancelRequisition($id)
    {
        $req = Requisition::find($id);
        $req->status = 1;
        return $req->save();
    }

    public function saveInternalOrder()
    {
        \DB::beginTransaction();
        $stack = self::order_item_stack(array_keys($this->request->all()));
        $order = new InternalOrder;
        $order->author = \Auth::user()->id;
        $order->dispatching_store = $this->request->dispatching_store;
        $order->requesting_store = $this->request->requesting_store;
        $order->deliver_date = $this->request->deliver_date;
        $order->save();
        foreach ($stack as $index) {
            $item = 'item' . $index;
            $quantity = 'qty' . $index;
            $details = new InternalOrderDetails();
            $details->internal_order = $order->id;
            $details->item = $this->request->$item;
            $details->quantity = $this->request->$quantity;
            $details->save();
        }
        \DB::commit();
        return $order->id;
    }

    public function sendOrderToCollabmed(Request $request)
    {
        $order = new OrderToCollabmed();
        $order->order = $request->order;
        $order->client = config('practice.name');
        return $order->save();
    }

    /**
     * @param bool $true
     * @return mixed
     */
    public function getSales($true = false)
    {
        $sales = InventoryBatchProductSales::where('created_at', '>', Carbon::today());
        if ($true) {
            $sales = $sales->whereShop($true);
        }
        return $sales->get();
    }

    /**
     * @throws \Illuminate\Support\Facades\Exception
     */
    public function dispatchInternal()
    {
        $to_dispatch = \request('dispatch');
        $order_id = \request('order_id');
        \DB::beginTransaction();
        try {
            foreach ($to_dispatch as $k => $v) {
                $item = InternalOrderDetails::find($k);
                $_needed = $item->quantity - $item->dispatched;
                if ($v > $_needed) {
                    flash('Cannot dispatch more than requested', 'danger');
                    throw new \Exception('Cannot dispatch more than requested');
                }
                InternalOrderDispatch::create([
                    'item_id' => $item->id,
                    'qty_dispatched' => $v,
                ]);
            }
        } catch (\Exception $e) {
            return \DB::rollBack();
        }
        \DB::commit();
        return $order_id;
    }

}
