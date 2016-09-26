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

use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\InventoryCategories;
use Ignite\Inventory\Entities\InventoryDispensing;
use Ignite\Inventory\Entities\InventoryPayments;
use Ignite\Inventory\Entities\InventoryPaymentTerms;
use Ignite\Inventory\Entities\InventoryProductPrice;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\Customer;
use Ignite\Inventory\Entities\InventoryPurchaseOrderDetails;
use Ignite\Inventory\Entities\InventoryPurchaseOrders;
use Ignite\Inventory\Entities\InventoryStock;
use Ignite\Inventory\Entities\InventoryStockAdjustment;
use Ignite\Inventory\Entities\InventoryProductMarkup;
use Ignite\Inventory\Entities\InventoryInvoice;
use Ignite\Inventory\Entities\InventorySupplier;
use Ignite\Inventory\Entities\InventoryTaxCategory;
use Ignite\Inventory\Entities\InventoryUnits;
use Ignite\Inventory\Entities\InventoryProductDiscount;
use Ignite\Inventory\Entities\InventoryCategoryPrice;
use Ignite\Inventory\Events\MarkupWasAdjusted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ignite\Inventory\Entities\InventorySalesReturn;
use Ignite\Inventory\Entities\InventoryInsuranceDetails;

/**
 * Description of InventoryFunctions
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class InventoryFunctions {

    /**
     * Add a supplier to the database
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public static function add_supplier(Request $request, $id = null) {
        $supplier = InventorySupplier::findOrNew($id);
        $supplier->name = ucfirst($request->name);
        $supplier->address = $request->address;
        $supplier->telephone = $request->telephone;
        $supplier->mobile = $request->mobile;
        $supplier->post_code = $request->post_code;
        $supplier->email = $request->email;
        $supplier->building = $request->building;
        $supplier->fax = $request->fax;
        $supplier->street = $request->street;
        $supplier->town = $request->town;
        return $supplier->save();
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public static function add_product_category(Request $request, $id = null) {
        $category = InventoryCategories::findOrNew($id);
        $category->name = ucfirst($request->name);
        $category->parent = $request->parent_category;
        $category->credit_markup = $request->credit_markup;
        $category->cash_markup = $request->cash_markup;
        $result = $category->save();
        return $result;
    }

    /**
     * Add tax category
     * @param Request $request
     * @param int|null $id
     * @return mixed
     */
    public static function add_tax_category(Request $request, $id = null) {
        $category = InventoryTaxCategory::findOrNew($id);
        $category->name = ucfirst($request->name);
        $category->rate = $request->rate;
        return $category->save();
    }

    /**
     * Add to database /or update
     * @param Request $request
     * @param int|null $id
     * @return mixed
     */
    public static function add_unit_of_measure(Request $request, $id = null) {
        $unit = InventoryUnits::findOrNew($id);
        $unit->name = ucfirst($request->name);
        $unit->description = $request->description;
        return $unit->save();
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public static function add_product(Request $request, $id = null) {
        DB::transaction(function () use ($request, $id) {
            $product = InventoryProducts::findOrNew($id);
            $product->name = ucfirst($request->name);
            $product->description = $request->description;
            $product->category = $request->category;
            $product->unit = $request->unit;
            $product->formulation = $request->formulation;
            $product->label_type = $request->label_type;
            $product->strength = $request->strength;
            $product->save();
            //$price = InventoryProductPrice::firstOrNew(['product' => $product->id]);
            //$price->price = $request->unit_cost;
            //$price->selling = $request->selling_price;
            //$price->save();
        });
        return true;
    }

    /**
     * Add pament term
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public static function add_payment_term(Request $request, $id = null) {
        $term = InventoryPaymentTerms::findOrNew($id);
        $term->terms = $request->terms;
        $term->description = $request->description;
        return $term->save();
    }

    /**
     * Create an LPO
     * @param Request $request
     * @param int|null $id
     * @return bool
     */
    public static function add_new_order(Request $request, $id = null) {
        DB::transaction(function () use ($request, $id) {
            $order = new InventoryPurchaseOrders();
            $order->supplier = $request->supplier;
            $order->deliver_date = new \Date($request->delivery_date);
            $order->payment_terms = $request->payment_terms;
            $order->payment_mode = $request->payment_mode;
            $order->user = $request->user()->id;
            $order->save();

            $request->session()->put('last_order', $order->id);
            $stack = self::order_item_stack(array_keys($request->all()));
            foreach ($stack as $index) {
                $item = 'item' . $index;
                $price = 'price' . $index;
                $quantity = 'qty' . $index;
                $details = new InventoryPurchaseOrderDetails();
                if ($request->has($item) && $request->has($price) && $request->has($quantity)) {
                    $details->order = $order->id;
                    $details->product = $request->$item;
                    $details->price = $request->$price;
                    $details->quantity = $request->$quantity;
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
    private static function order_item_stack($keys) {
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
    public static function saveProdPrice(Request $request) {
        foreach ($request->products as $index => $product_id) {
            $product_price = InventoryProductPrice::firstOrNew(['product' => $product_id]);
            $product_price->product = $request->products[$index];
            $product_price->selling = $request->prices[$index];
            $product_price->save();
        }
        return 'saved';
    }

    public static function updateProdPrice(Request $request) {
        foreach ($request->id as $index => $id) {
            $price = InventoryProductPrice::find($id);
            $price->price = $request->price[$index];
            $price->save();
        }
        return 'saved';
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function saveProdDiscount(Request $request) {
        foreach ($request->products as $index => $product_id) {
            $product_discount = InventoryProductDiscount::firstOrNew(['product' => $product_id]);
            $product_discount->product = $request->products[$index];
            $product_discount->discount = $request->discounts[$index];
            $product_discount->end_date = new \Date($request->end_dates[$index]);
            $product_discount->save();
        }
        return 'saved';
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function markup(Request $request) {
        foreach ($request->product as $index => $product_id) {
            $markup = InventoryProductMarkup::firstOrNew(['product' => $product_id]);
            $markup->product = $request->product[$index];
            $markup->markup = $request->markup[$index];
            $markup->save();
        }
        return 'saved';
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function saveCatPrice(Request $request) {
        foreach ($request->cats as $index => $cat_id) {
            $cat_price = InventoryCategoryPrice::firstOrNew(['category' => $cat_id]);
            $cat_price->category = $request->cats[$index];
            $cat_price->price = $request->prices[$index];
            $cat_price->save();
        }
        return 'saved';
    }

    /**
     * @param $id
     * @return bool
     */
    public static function approveLPO($id) {
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
    public static function record_sales(Request $request, $id = null) {
        DB::beginTransaction();
        try {
            $receipt = config('system.receipt_prefix') . mt_rand(1000, 9000) . '-' . date('d/m/y');
            $stack = self::order_item_stack(array_keys($request->all()));
            if ($request->first_name || $request->phone) {
                $customer = Customer::firstOrNew(['phone' => $request->phone]);
                $customer->first_name = $request->first_name;
                $customer->last_name = $request->last_name;
                $customer->email = $request->email;
                $customer->phone = $request->phone;
                $customer->save();
            }
            $sales = new InventoryBatchProductSales;
            $sales->user = $request->user()->id;
            if (isset($customer->id)) {
                $sales->customer = $customer->id;
            }
            $sales->payment_mode = $request->payment_mode;

            $sales->receipt = strtoupper($receipt);
            $sales->paid = ($sales->payment_mode != 'insurance');
            $sales->save();
            foreach ($stack as $index) {
                $item = 'item' . $index;
                $price = 'price' . $index;
                $batch = 'batch' . $index;
                $quantity = 'qty' . $index;
                $discount = 'dis' . $index;
                if ($request->has($item) && $request->has($price) && $request->has($quantity)) {
                    $sale = new InventoryDispensing;
                    $sale->batch = $sales->id;
                    $sale->product = $request->$item;
                    $sale->price = $request->$price;
                    $sale->quantity = $request->$quantity;
                    $sale->discount = $request->$discount;
                    //move items in queue
                    $stock = InventoryStock::where('product', '=', $request->$item)->first();
                    if ($stock->quantity < $request->$quantity) {
                        DB::rollback();
                        flash()->error("An item you tried to sell is unfortunately out of stock...");
                        redirect()->back();
                    }
                    if ($request->$batch > 0) {
                        self::update_queue($sale->product, $request->$batch, $sale->quantity);
                    }
                    $sale->save();
                }
            }
            self::take_products($sales); //notify stock
            self::record_payments($request, $receipt, $request->payment_mode);
            $request->session()->put('receipt_id', $sales->id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            flash()->warning("Ooops! something went wrong... Be sure any product added to cart is in the system (<a target='blank' href='/inventory/goods/receive'>was received</a>)");
        }//Catch
    }

    /**
     * @param Request $request
     * @param $receipt
     * @param $payment_mode
     * @return bool
     */
    private static function record_payments(Request $request, $receipt, $payment_mode) {
        $pay = new InventoryPayments;
        $pay->receipt = strtoupper($receipt); //$receipt;
        //user and patient
        $pay->user = $request->user()->id;

        if ($payment_mode == 'cash') {
            //cash
            $pay->CashAmount = $request->amount;
        } elseif ($payment_mode == 'mpesa') {
            //mpesa
            $pay->MpesaAmount = $request->amount;
            $pay->MpesaReference = strtoupper($request->MpesaRef);
        } elseif ($payment_mode == 'cheque') {
            //cheque
            $pay->ChequeName = strtoupper($request->Ac_holder_name);
            $pay->ChequeDate = $request->ChequeDate;
            $pay->ChequeAmount = $request->amount;
            $pay->ChequeName = $request->ChequeNumber;
            $pay->ChequeBank = $request->Bank;
            $pay->ChequeBankBranch = $request->Branch;
        } elseif ($payment_mode == 'card') {
            //card
            $pay->CardName = $request->CardNames;
            $pay->CardType = $request->CardType;
            $pay->CardAmount = $request->amount;
            $pay->CardSecurity = $request->security_code;
            $pay->CardExpiry = $request->expiry_month + "/" + $request->expiry_year;
            $pay->CardNumber = $request->CardNumber;
        } elseif ($payment_mode == 'insurance') {
            //insurance
            $pay->scheme = $request->InsuranceScheme;
            $pay->InsuranceAmount = $request->amount;
            //Save Client
            $customer = Customer::firstOrNew(['phone' => $request->phone]);
            $customer->first_name = $request->first_name_ins;
            $customer->last_name = $request->last_name_ins;
            $customer->email = $request->email_ins;
            $customer->phone = $request->phone_ins;
            $customer->save();
            //Save Credit Details
            $details = new InventoryInsuranceDetails;
            $details->customer = $customer->id;
            $details->insurance_company = $request->company;
            $details->credit_scheme = $request->scheme;
            $details->policy_no = $request->policy_number;
            $details->principal = $request->principal;
            $details->date_of_birth = new \Date($request->principal_dob);
            $details->relation = $request->principal_relationship;
            $details->save();
        } else {
            //
        }

        return $pay->save();
    }

    /**
     * @param InventoryBatchProductSales $sale
     */
    private static function take_products(InventoryBatchProductSales $sale) {
        foreach ($sale->goodies as $vending) {
            $adj = new InventoryStockAdjustment;
            $adj->quantity = $vending->quantity;
            $adj->type = 'sales';
            $adj->method = '-';
            $adj->user = \Auth::user()->id;
            $adj->product = $vending->product;
            $adj->reason = 'Product sales Receipt #' . $vending->receipt_no;
            $adj->save();
            self::adjust_stock($adj);
        }
    }

    /**
     * @todo Rename to set product price
     * @param InventoryBatch $incoming
     * @return bool
     */
    public static function apply_markup(InventoryBatch $incoming) {
        DB::transaction(function () use ($incoming) {
            foreach ($incoming->products as $item) {
                $markup = $item->products->categories->cash_markup;
                $price = new InventoryProductPrice(); //::firstOrNew(['product' => $item->product]);
                $price->product = $item->product;
                $price->price = $item->unit_cost;
                $price->batch = $incoming->id;
                $price->selling = null; // empty($markup) ? 0 : ($markup + 100) / 100 * $price->price;
                $price->save();
                self::enQueueProductBatch($price->batch, $price->product);
            }
        });
        return true;
    }

    public static function enQueueProductBatch($batch, $product) {
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

    public static function deQueueProductBatch($batch, $product) {
        $q = InventoryBatchPurchases::query()
                ->where('product', '=', $product)
                ->where('batch', '=', $batch)
                ->first();
        $q->active = FALSE;
        return $q->save();
    }

    public static function activateQueue($batch, $product) {
        $q = InventoryBatchPurchases::query()
                ->where('product', '=', $product)
                ->where('batch', '=', $batch)
                ->first();
        $q->active = TRUE;
        return $q->save();
    }

    public static function update_queue($product, $batch, $qty) {
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

            self::deQueueProductBatch($b_purchase->batch, $b_purchase->product);
            if (isset($next)) {
                self::activateQueue($next->batch, $next->product);
                $next->qty_sold+= $surplus;
                $next->save();
            }
            $b_purchase->qty_sold+= $batch_items_remaining;
        } else {
            $b_purchase->qty_sold+= $qty;
        }
        $b_purchase->save();
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function receive_goods_direct(Request $request) {
        DB::transaction(function () use ($request) {
            $stack = self::order_item_stack(array_keys($request->all()));
            $order = new InventoryBatch;
            $order->user = $request->user()->id;
            $order->supplier = $request->supplier;
            $order->save();
            foreach ($stack as $index) {
                $item = 'item' . $index;
                $price = 'price' . $index;
                $quantity = 'qty' . $index;
                $bonus = 'bonus' . $index;
                $discount = 'dis' . $index;
                $expiry = 'expiry' . $index;
                $package = 'package' . $index;
                if ($request->has($item) && $request->has($price) && $request->has($quantity)) {
                    $details = new InventoryBatchPurchases;
                    $details->batch = $order->id;
                    $details->bonus = $request->$bonus;
                    $details->product = $request->$item;
                    if ($request->$package > 0) {
                        $details->unit_cost = $request->$price / $request->$package;
                    } else {
                        $details->unit_cost = $request->$price;
                    }
                    $details->quantity = $request->$quantity;
                    $details->discount = $request->$discount;
                    $details->expiry_date = $request->$expiry;
                    $details->package_size = $request->$package;
                    $details->save();
                }
            }
            //$job = (new StockUpdate($order, true))->onQueue('stock');
            //dispatch($job);
            self::update_stock_from_lpo($order, true);
            $request->session()->put('last_receive', $order->id);
        });

        return true;
    }

    /**
     * Receive products from lpo
     * @param Request $request
     * @return bool
     */
    public static function receive_from_lpo(Request $request) {
        DB::transaction(function () use ($request) {
            $stack = self::order_item_stack(array_keys($request->all()));
            $order = new InventoryBatch;
            $order->order = $request->lpo;
            $order->user = $request->user()->id;
            $order->supplier = $request->supplier;
            $order->save();
            foreach ($stack as $index) {
                $item = 'item' . $index;
                $price = 'price' . $index;
                $quantity = 'qty' . $index;
                $bonus = 'bonus' . $index;
                $discount = 'dis' . $index;
                $expiry = 'expiry' . $index;
                $package = 'package' . $index;
                if ($request->has($item) && $request->has($price) && $request->has($quantity)) {
                    $details = new InventoryBatchPurchases;
                    $details->batch = $order->id;
                    $details->bonus = $request->$bonus;
                    $details->product = $request->$item;
                    $details->unit_cost = $request->$price / $request->$package;
                    $details->quantity = $request->$quantity;
                    $details->discount = $request->$discount;
                    $details->expiry_date = $request->$expiry;
                    $details->package_size = $request->$package;
                    $details->save();
                }
            }
            $lpo = $order->lpo;
            $lpo->status = 3;
            $lpo->save();
            /* $job = (new StockUpdate($order))->onQueue('stock');
              dispatch($job); */
            self::update_stock_from_lpo($order);
            $request->session()->put('last_receive', $order->id);
        });

        return true;
    }

    /**
     * @param InventoryBatch $batch
     * @param bool $direct
     * @return bool
     */
    public static function update_stock_from_lpo(InventoryBatch $batch, $direct = false) {
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
                $adj->save();
                self::adjust_stock($adj);
            }
        });
        event(new MarkupWasAdjusted($batch));
        return true;
    }

    /**
     * @param InventoryStockAdjustment $adj
     * @return bool
     */
    private static function adjust_stock(InventoryStockAdjustment $adj) {
        $stock = InventoryStock::firstOrNew(['product' => $adj->product]);
        $curr = $stock->quantity;
        if (empty($stock->quantity)) {
            $curr = 0;
        }
        $stock->quantity = ($adj->method == '+') ? $curr + $adj->quantity : $curr - $adj->quantity;
        return $stock->save();
    }

    /**
     * @param Request $request
     * @param $id
     * @return bool
     */
    public static function set_stock_value(Request $request, $id) {
        DB::transaction(function () use ($request, $id) {
            $curr = InventoryStock::firstOrNew(['product' => $id])->quantity;
            if (empty($curr)) {
                $curr = 0;
            }
            $adj = new InventoryStockAdjustment;
            $adj->product = $id;
            $adj->quantity = abs($request->quantity - $curr);
            $adj->user = $request->user()->id;
            $adj->method = ($request->quantity >= $curr) ? '+' : '-';
            $adj->reason = $request->reason;
            $adj->type = 'manual';
            $adj->approved = 'no';
            $adj->save();
            self::adjust_stock($adj);
        });
        return true;
    }

    /**
     * @param Request $request
     * @return bool
     */
    public static function sales_return(Request $request) {
        DB::transaction(function () use ($request) {

            $sreturn = new InventorySalesReturn;
            $sreturn->product = $request->product;
            $sreturn->receipt_no = $request->rcpt;
            $sreturn->quantity = $request->qty;
            $sreturn->reason = $request->reason;
            $sreturn->save();

            //update stock
            $curr = InventoryStock::firstOrNew(['product' => $request->product])->quantity;
            if (empty($curr)) {
                $curr = 0;
            }

            $adj = new InventoryStockAdjustment;
            $adj->product = $request->product;
            $adj->quantity = $request->qty;
            $adj->user = $request->user()->id;
            $adj->method = '+';
            $adj->reason = 'Sales Return';
            $adj->type = 'sales';
            $adj->save();
            self::adjust_stock($adj);
        });
        return true;
    }

    /**
     * @param Request $request
     */
    public static function supplier_invoice(Request $request) {
        $inv = new InventoryInvoice;
        $inv->creditor = $request->creditor;
        $inv->amount = $request->amount;
        $inv->gl_account = $request->gl_account;
        $inv->date = $request->date;
        $inv->due_date = $request->due_date;
        $inv->status = $request->status;
        $inv->description = $request->description;
        $inv->number = $request->number;
        $inv->save();
    }

}
