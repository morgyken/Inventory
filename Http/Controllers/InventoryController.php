<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Entities\InventoryCategories;
use Ignite\Inventory\Entities\InventoryPaymentTerms;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\InventoryInvoice;
use Ignite\Finance\Entities\BankAccount;
use Ignite\Finance\Entities\FinanceGlAccounts;
use Ignite\Finance\Entities\FinanceInvoicePayment;
use Ignite\Inventory\Entities\InternalOrder;
use Ignite\Inventory\Entities\Store;
use Ignite\Inventory\Entities\InventoryProductMarkup;
use Ignite\Inventory\Entities\InventoryPurchaseOrders;
use Ignite\Inventory\Entities\InventoryProductPrice;
use Ignite\Inventory\Entities\InventoryProductDiscount;
use Ignite\Inventory\Entities\InventoryCategoryPrice;
use Ignite\Inventory\Entities\InventoryStockAdjustment;
use Ignite\Inventory\Entities\InventorySupplier;
use Ignite\Inventory\Entities\InventoryTaxCategory;
use Ignite\Inventory\Entities\InventoryUnits;
use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Http\Requests\AddSupplierRequest;
use Ignite\Inventory\Http\Requests\AdjustStockRequest;
use Ignite\Inventory\Repositories\InventoryRepository;
use Illuminate\Http\Request;
use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\Requisition;
use Ignite\Inventory\Entities\RequisitionDetails;

class InventoryController extends AdminBaseController
{

    /**
     * @var Request Incoming HTTP request
     */
    protected $request;

    /**
     * @var InventoryRepository
     */
    protected $inventoryRepository;

    public function __construct(Request $request, InventoryRepository $inventoryRepository)
    {
        parent::__construct();
        $this->request = $request;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function index()
    {
        return view('inventory::index');
    }

    public function suppliers($id = null)
    {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->add_supplier()) {
                flash("Supplier details saved");
                return redirect()->route('inventory.suppliers');
            }
        }
        $this->data['supplier'] = InventorySupplier::findOrNew($id);
        $this->data['suppliers'] = InventorySupplier::all();
        return view('inventory::suppliers', ['data' => $this->data]);
    }

    public function supplier_invoice($id = null)
    {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->supplier_invoice($this->request)) {
                flash('Invoice Saved');
                return back();
            }
        }
        $this->data['inv'] = InventoryInvoice::all();
        $this->data['batch'] = InventoryBatch::all();
        $this->data['gl_accounts'] = FinanceGlAccounts::all();
        $this->data['suppliers'] = InventorySupplier::all();
        return view('inventory::supplier_invoice', ['data' => $this->data]);
    }

    public function supplier_invoice_details($id)
    {
        $this->data['accounts'] = BankAccount::all();
        $this->data['inv'] = InventoryInvoice::find($id);
        $this->data['batch'] = InventoryBatch::where('id', '=', $this->data['inv']->grn)->first();
        // Received Items
        $purchases = InventoryBatchPurchases::query();
        $this->data['items'] = $purchases->where('batch', '=', $this->data['inv']->grn)->get();
        //Prior payments for this invoice
        $this->data['payments'] = FinanceInvoicePayment::where('invoice', '=', $id)->get();
        $paid_amount = 0;
        foreach ($this->data['payments'] as $p) {
            $paid_amount += $p->amount;
        }
        $this->data['amount_paid'] = $paid_amount;
        return view('inventory::supplier_invoice_details', ['data' => $this->data]);
    }

    public function product_cat($id = null)
    {
        if ($this->request->isMethod('post')) {
            //$this->validate(Validation::add_product_category());
            if ($this->inventoryRepository->add_product_category($id)) {
                flash('Product category saved!');
                return redirect()->route('inventory.product_cat');
            }
        }
        $this->data['category'] = InventoryCategories::findOrNew($id);
        $this->data['product_categories'] = InventoryCategories::all();
        return view('inventory::products.product_categories', ['data' => $this->data]);
    }

    public function tax_categories($id = null)
    {
        if ($this->request->isMethod('post')) {
            //$this->validate(Validation::add_tax_category());
            if ($this->inventoryRepository->add_tax_category($id)) {
                flash('Tax category saved!');
                return redirect()->route('inventory.tax_categories');
            }
        }
        $this->data['category'] = InventoryTaxCategory::findOrNew($id);
        $this->data['tax_categories'] = InventoryTaxCategory::all();
        return view('inventory::tax_categories', ['data' => $this->data]);
    }

    public function units_of_measurement($id = null)
    {
        if ($this->request->isMethod('post')) {
            //$this->validate(Validation::add_unit_of_measure());
            if ($this->inventoryRepository->add_unit_of_measure($id)) {
                flash('Unit saved!');
                return redirect()->route('inventory.units_of_measurement'); //->with('success',);
            }
        }
        $this->data['unit'] = InventoryUnits::findOrNew($id);
        $this->data['units_of_measure'] = InventoryUnits::all();
        return view('inventory::units_of_measure', ['data' => $this->data]);
    }

    public function add_product($id = null)
    {
        if ($this->request->isMethod('post')) {
            // //$this->validate(Validation::add_product());
            if ($this->inventoryRepository->add_product($this->request->id)) {
                flash('Product Saved');
                return redirect()->route('inventory.products');
            }
        }
        $this->data['product'] = InventoryProducts::findOrNew($id);
        $this->data['category'] = InventoryCategories::all();
        return view('inventory::products.add_product', ['data' => $this->data]);
    }

    public function products($id = null)
    {
        $this->data['products'] = InventoryProducts::all();
        return view('inventory::products', ['data' => $this->data]);
    }

    public function view_stock()
    {
        $this->data['products'] = InventoryProducts::all();
        return view('inventory::products.view_stocks', ['data' => $this->data]);
    }

    public function adjust_stock_do(AdjustStockRequest $request, $red = false)
    {
        if ($this->inventoryRepository->set_stock_value()) {
            if (!$red) {
                flash('Stock adjusted');
                return redirect()->route('inventory.view_stock');
            }
            return response()->json(['saved' => true]);
        }
    }

    public function stockTake()
    {
        $this->data['products'] = InventoryProducts::all();
        return view('inventory::products.take_stocks', ['data' => $this->data]);
    }

    public function adjust_stock($id)
    {
        $this->data['product'] = InventoryProducts::find($id);
        $this->data['adjustments'] = InventoryStockAdjustment::all();
        return view('inventory::products.adjust_stock', ['data' => $this->data]);
    }

    public function stock_adjustments()
    {
        $this->data['adjustments'] = InventoryStockAdjustment::all();
        return view('inventory::products.stock_adjustments', ['data' => $this->data]);
    }

    public function payment_terms($id = null)
    {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->add_payment_term($id)) {
                flash('Product saved');
                return back();
            }
        }
        $this->data['terms'] = InventoryPaymentTerms::findOrNew($id);
        $this->data['payment_terms'] = InventoryPaymentTerms::all();
        return view('inventory::payment_terms', ['data' => $this->data]);
    }

    public function add_lpo($id = null)
    {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->add_new_order($id)) {
                $x = \Session::get('last_order');
                flash('LPO created');
                return redirect()->route('inventory.order_details', $x);
            }
        }

        if (isset($this->request->requisition)) {
            $this->data['requisition'] = Requisition::find($this->request->requisition);
            $this->data['details'] = RequisitionDetails::whereRequisition($this->request->requisition)->get();
        }

        $this->data['lpo'] = InventoryPurchaseOrders::findOrNew($id);
        return view('inventory::new_purchase_order', ['data' => $this->data]);
    }

    public function purchase_orders()
    {
        $this->data['orders'] = InventoryPurchaseOrders::all();
        $this->data['suppliers'] = InventoryPurchaseOrders::all();
        return view('inventory::product_orders', ['data' => $this->data]);
    }

    public function order_details($id)
    {
        $this->data['order'] = InventoryPurchaseOrders::findOrFail($id);
        return view('inventory::order_details', ['data' => $this->data]);
    }

    public function setProductDiscount()
    {
        $this->data['products'] = InventoryProducts::all();
        $this->data['discount'] = InventoryProductDiscount::all();
        return view('inventory::set_product_discount', ['data' => $this->data]);
    }

    public function delProductDiscount()
    {
        $id = $this->request->id;
        $this_dis = InventoryProductDiscount::find($id);
        $this_dis->delete();

        $this->data['products'] = InventoryProducts::all();
        $this->data['discount'] = InventoryProductDiscount::all();
        return view('inventory::set_product_discount', ['data' => $this->data]);
    }

    public function markup()
    {
        $this->data['products'] = InventoryProducts::all();
        $this->data['markup'] = InventoryProductMarkup::all();
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->markup($this->request)) {
                flash('Product Markup percentage(s) saved');
                return redirect()->route('inventory.product.markup');
            }
        }
        return view('inventory::set_product_markup', ['data' => $this->data]);
    }

    public function delMarkup()
    {
        InventoryProductMarkup::find($this->request->id)->delete();
        $this->data['products'] = InventoryProducts::all();
        $this->data['markup'] = InventoryProductMarkup::all();
        return redirect()->route('inventory.product.markup', ['data' => $this->data]);
    }

    public function saveProductDiscount()
    {
        $this->data['products'] = InventoryProducts::all();
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->saveProdDiscount($this->request)) {
                $x = \Session::get('last_order');
                flash('Product Discount(s) Saved');
                return redirect()->route('inventory.product.discount', $x); //->with('success', );
            }
        } else {
            flash()->error('Product Discount(s) Could not be Saved');
            return redirect()->route('inventory.product.discount', ['data' => $this->data]);
        }
    }

    public function setProductPrice()
    {
//        $this->data['price'] = InventoryProductPrice::all();
        $this->data['products'] = InventoryProducts::all();
        return view('inventory::products.set_product_price', ['data' => $this->data]);
    }

    public function delProductPrice()
    {
        InventoryProductPrice::find($this->request->id)->delete();
        $this->data['products'] = InventoryProducts::all();
        $this->data['price'] = InventoryProductPrice::all();
        flash('Item price deleted successfully');
        return redirect()->route('inventory.product.price', ['data' => $this->data]);
    }

    public function editProductPrice()
    {
        if ($this->inventoryRepository->updateProdPrice($this->request)) {
            flash('Item price(s) updated successfully');
            return redirect()->route('inventory.product.price', ['data' => $this->data]);
        }
        $this->data['products'] = InventoryProducts::all();
        $this->data['price'] = InventoryProductPrice::all();
        flash()->warning('Something went wrong, please try again');
        return redirect()->route('inventory.product.price', ['data' => $this->data]);
    }

    public function saveItemPrices()
    {
        $this->data['products'] = InventoryProducts::all();
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->saveProdPrice($this->request)) {
                $x = \Session::get('last_order');
                flash('Product Price(S) Saved');
                return redirect()->route('inventory.product.price', $x); //->with('success',);
            }
        } else {
            flash()->error('Product Price(s) Could not be Saved');
            return redirect()->route('inventory.product.price', ['data' => $this->data]);
        }
    }

    public function setCategoryPrice()
    {
        $this->data['price'] = InventoryCategoryPrice::all();
        $this->data['product_categories'] = InventoryCategories::all();
        return view('inventory::set_category_prices', ['data' => $this->data]);
    }

    public function delCategoryPrice()
    {
        InventoryCategoryPrice::find($this->request->id)->delete();
        $this->data['price'] = InventoryCategoryPrice::all();
        $this->data['product_categories'] = InventoryCategories::all();
        flash('Category price deleted');
        return view('inventory::set_category_prices')
            ->with('data', $this->data);
    }

    public function saveCategoryPrice()
    {
        $this->data['product_categories'] = InventoryCategories::all();
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->saveCatPrice($this->request)) {
                $x = \Session::get('last_order');
                flash('Category Price(S) Saved');
                return redirect()->route('inventory.category.price', $x); //->with('success');
            }
        } else {
            flash()->error('Category Price(s) Could not be Saved');
            return redirect()->route('inventory.category.price', ['data' => $this->data]);
        }
    }

    public function approveLPO($id)
    {
        $this->data['order'] = InventoryPurchaseOrders::findOrFail($id);
        if ($this->inventoryRepository->approveLPO($id)) {
            flash('LPO Approved Successfully');
            return redirect()->back();
        } else {
            flash()->error('LPO Could not be Approved, please try again');
            return redirect()->back();
        }
    }

    public function receive_goods()
    {
        $this->data['lpos'] = InventoryPurchaseOrders::approved()->get();
        $this->data['deliveries'] = InventoryBatch::all();
        return view('inventory::receive_goods', ['data' => $this->data]);
    }

    public function grns()
    {
        $this->data['deliveries'] = InventoryBatch::all();
        return view('inventory::grns', ['data' => $this->data]);
    }

    public function receive_lpo($id)
    {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->receive_from_lpo($this->request)) {
                $batch_id = \Session::get('last_receive');
                flash('Order Goods have been Received Successfully');
                return redirect()->route('inventory.purchase_details', $batch_id);
            }
        }
        $this->data['deliveries'] = InventoryBatch::all();
        $this->data['order'] = InventoryPurchaseOrders::findOrFail($id);
        return view('inventory::receive_lpo_goods', ['data' => $this->data]);
    }

    public function purchase_details($batch)
    {
        $this->data['batch'] = $batch;
        $this->data['bought'] = InventoryBatchPurchases::where('batch', '=', $batch)->get();
        return view('inventory::after_receive')
            ->with('data', $this->data);
    }

    public function receive_direct()
    {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->receive_goods_direct($this->request)) {
                $batch_id = \Session::get('last_receive');
                flash('Order Goods have been Received Successfully');
                return redirect()->route('inventory.purchase_details', $batch_id);
            }
        }
        $this->data['supplier'] = InventorySupplier::find($this->request->supplier);
        return view('inventory::receive_direct_goods', ['data' => $this->data]);
    }

    public function batch_details($id)
    {
        $this->data['del'] = InventoryBatch::find($id);
        //dd($id);
        $this->data['accounts'] = BankAccount::all();
        $purchases = InventoryBatchPurchases::query();
        $this->data['items'] = $purchases->where('batch', '=', $id)->get();
        return view('inventory::batch_details', ['data' => $this->data]);
    }

    public function Requisition()
    {
        return view('inventory::new_requisition', ['data' => $this->data]);
    }

    public function SaveRequisition()
    {
        if ($this->inventoryRepository->SaveRequisition($this->request)) {
            flash('Your item requisition was successfully placed');
            return redirect()->back(); //route('inventory.purchase_details', $batch_id);
        }
    }

    public function ViewRequisitions()
    {
        $this->data['requisitions'] = Requisition::all()->sortByDesc("id");
        if (isset($this->request->id)) {
            $this->data['clicked'] = Requisition::find($this->request->id);
            $this->data['details'] = RequisitionDetails::whereRequisition($this->request->id)->get();
        }
        return view('inventory::requisitions', ['data' => $this->data]);
    }

    public function CancelRequisition()
    {
        $req = Requisition::find($this->request->id);
        $req->status = 1;
        $req->save();
        flash('Item requisition was marked as settled');
        return redirect()->back(); //route('inventory.purchase_details', $batch_id);
    }

    public function ViewInternalOrders()
    {
        $this->data['orders'] = InternalOrder::all();
        return view('inventory::internalorders_all', ['data' => $this->data]);
    }

    public function ManageInternalOrders()
    {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->SaveInternalOrder($this->request)) {
                flash('Internal Order placed successfully');
                return redirect()->back(); //route('inventory.purchase_details', $batch_id);
            }
        }
        $this->data['orders'] = InternalOrder::all();
        $this->data['stores'] = Store::all();
        return view('inventory::internalorders', ['data' => $this->data]);
    }

    public function ManageStores()
    {
        if ($this->request->isMethod('post')) {
            $store = new Store;
            $store->name = $this->request->name;
            $store->description = $this->request->desc;
            $store->save();
        }
        $this->data['stores'] = Store::all();
        if (isset($this->request->id)) {
            $this->data['store'] = Store::find($this->request->id);
        }
        return view('inventory::stores', ['data' => $this->data]);
    }

}
