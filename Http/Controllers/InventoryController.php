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

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Entities\InventoryCategories;
use Ignite\Inventory\Entities\InventoryPaymentTerms;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\InventoryInvoice;
use Ignite\Finance\Entities\BankAccount;
use Ignite\Finance\Entities\FinanceGlAccounts;
use Ignite\Inventory\Entities\InternalOrder;
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
use Illuminate\Http\Request;
use Ignite\Inventory\Library\Validation;
use Ignite\Inventory\Library\InventoryFunctions;
use Ignite\Inventory\Entities\InventoryBatchPurchases;

class InventoryController extends AdminBaseController  {

    /**
     * @var Request Incoming HTTP request
     */
    protected $request;

    /**
     * @var array The application featured data
     */
    protected $data = [];

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function index() {
        return view('inventory::index');
    }

    public function add_edit_suppliers($id = null) {
        if ($this->request->isMethod('post')) {
            $this->validate($this->request, Validation::add_supplier());
            if (InventoryFunctions::add_supplier($this->request, $id)) {
                return redirect()->route('inventory.suppliers')->with('success', 'Supplier details saved!');
            }
        }
        $this->data['supplier'] = InventorySupplier::findOrNew($id);
        return view('inventory::add_supplier')->with('data', $this->data);
    }

    public function suppliers($id = null) {
        if ($this->request->isMethod('post')) {
            $this->validate($this->request, Validation::add_supplier());
            if (InventoryFunctions::add_supplier($this->request, $id)) {
                flash('Supplier details saved!');
                return redirect()->route('inventory.suppliers');
            }
        }
        $this->data['supplier'] = InventorySupplier::findOrNew($id);
        $this->data['suppliers'] = InventorySupplier::all();
        return view('inventory::suppliers')->with('data', $this->data);
    }

    public function supplier_invoice($id = null) {
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::supplier_invoice($this->request)) {
                flash('Invoice Saved');
                return \Redirect::back();
            }
        }
        $this->data['inv'] = InventoryInvoice::all();
        $this->data['batch'] = InventoryBatch::all();
        $this->data['gl_accounts'] = FinanceGlAccounts::all();
        $this->data['suppliers'] = InventorySupplier::all();
        return view('inventory::supplier_invoice')->with('data', $this->data);
    }

    public function supplier_invoice_details($id) {
        $this->data['accounts'] = BankAccount::all();
        $this->data['inv'] = InventoryInvoice::find($id);
        $this->data['batch'] = InventoryPurchaseOrders::find($this->data['inv']->batch);
        $bp = InventoryBatchPurchases::query();
        return view('inventory::supplier_invoice_details')->with('data', $this->data);
    }

    public function product_categories($id = null) {
        if ($this->request->isMethod('post')) {
            $this->validate($this->request, Validation::add_product_category());
            if (InventoryFunctions::add_product_category($this->request, $id)) {
                flash('Product category saved!');
                return redirect()->route('inventory.product_categories');
            }
        }
        $this->data['category'] = InventoryCategories::findOrNew($id);
        $this->data['product_categories'] = InventoryCategories::all();
        return view('inventory::products.product_categories')->with('data', $this->data);
    }

    public function tax_categories($id = null) {
        if ($this->request->isMethod('post')) {
            $this->validate($this->request, Validation::add_tax_category());
            if (InventoryFunctions::add_tax_category($this->request, $id)) {
                flash('Tax category saved!');
                return redirect()->route('inventory.tax_categories');
            }
        }
        $this->data['category'] = InventoryTaxCategory::findOrNew($id);
        $this->data['tax_categories'] = InventoryTaxCategory::all();
        return view('inventory::tax_categories')->with('data', $this->data);
    }

    public function units_of_measurement($id = null) {
        if ($this->request->isMethod('post')) {
            $this->validate($this->request, Validation::add_unit_of_measure());
            if (InventoryFunctions::add_unit_of_measure($this->request, $id)) {
                flash('Unit saved!');
                return redirect()->route('inventory.units_of_measurement'); //->with('success',);
            }
        }
        $this->data['unit'] = InventoryUnits::findOrNew($id);
        $this->data['units_of_measure'] = InventoryUnits::all();
        return view('inventory::units_of_measure')->with('data', $this->data);
    }

    public function add_product($id = null) {
        if ($this->request->isMethod('post')) {
            $this->validate($this->request, Validation::add_product());
            if (InventoryFunctions::add_product($this->request, $id)) {
                flash('Product Saved');
                return redirect()->route('inventory.products');
            }
        }
        $this->data['product'] = InventoryProducts::findOrNew($id);
        return view('inventory::add_product')->with('data', $this->data);
    }

    public function products($id = null) {
        $this->data['products'] = InventoryProducts::all();
        return view('inventory::products')->with('data', $this->data);
    }

    public function view_stock() {
        $this->data['products'] = InventoryProducts::all();
        return view('inventory::products.view_stocks')->with('data', $this->data);
    }

    public function adjust_stock($id) {
        if ($this->request->isMethod('post')) {
            $this->validate($this->request, Validation::adjust_stock());
            if (InventoryFunctions::set_stock_value($this->request, $id)) {
                flash('Stock adjusted');
                return redirect()->route('inventory.view_stock');
            }
        }
        $this->data['product'] = InventoryProducts::find($id);
        $this->data['adjustments'] = InventoryStockAdjustment::all();
        return view('inventory::products.adjust_stock')->with('data', $this->data);
    }

    public function stock_adjustments() {
        $this->data['adjustments'] = InventoryStockAdjustment::all();
        return view('inventory::products.stock_adjustments')->with('data', $this->data);
    }

    public function payment_terms($id = null) {
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::add_payment_term($this->request, $id)) {
                flash('Product saved');
                return back();
            }
        }
        $this->data['terms'] = InventoryPaymentTerms::findOrNew($id);
        $this->data['payment_terms'] = InventoryPaymentTerms::all();
        return view('inventory::payment_terms')->with('data', $this->data);
    }

    public function add_lpo($id = null) {
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::add_new_order($this->request, $id)) {
                $x = \Session::get('last_order');
                flash('LPO created');
                return redirect()->route('inventory.order_details', $x);
            }
        }
        $this->data['lpo'] = InventoryPurchaseOrders::findOrNew($id);
        return view('inventory::new_purchase_order')->with('data', $this->data);
    }

    public function purchase_orders() {
        $this->data['orders'] = InventoryPurchaseOrders::all();
        $this->data['suppliers'] = InventoryPurchaseOrders::all();
        return view('inventory::product_orders')->with('data', $this->data);
    }

    public function internal_orders() {
        $this->data['orders'] = InternalOrder::all();
        return view('inventory::internalorders')->with('data', $this->data);
    }

    public function order_details($id) {
        $this->data['order'] = InventoryPurchaseOrders::findOrFail($id);
        return view('inventory::order_details')->with('data', $this->data);
    }

    public function setProductDiscount() {
        $this->data['products'] = InventoryProducts::all();
        $this->data['discount'] = InventoryProductDiscount::all();
        return view('inventory::set_product_discount')->with('data', $this->data);
    }

    public function delProductDiscount() {
        $id = $this->request->id;
        $this_dis = InventoryProductDiscount::find($id);
        $this_dis->delete();

        $this->data['products'] = InventoryProducts::all();
        $this->data['discount'] = InventoryProductDiscount::all();
        return view('inventory::set_product_discount')->with('data', $this->data);
    }

    public function markup() {
        $this->data['products'] = InventoryProducts::all();
        $this->data['markup'] = InventoryProductMarkup::all();
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::markup($this->request)) {
                flash('Product Markup percentage(s) saved');
                return redirect()->route('inventory.product.markup');
            }
        }
        return view('inventory::set_product_markup')->with('data', $this->data);
    }

    public function delMarkup() {
        InventoryProductMarkup::find($this->request->id)->delete();
        $this->data['products'] = InventoryProducts::all();
        $this->data['markup'] = InventoryProductMarkup::all();
        return redirect()->route('inventory.product.markup')->with('data', $this->data);
    }

    public function saveProductDiscount() {
        $this->data['products'] = InventoryProducts::all();
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::saveProdDiscount($this->request)) {
                $x = \Session::get('last_order');
                flash('Product Discount(s) Saved');
                return redirect()->route('inventory.product.discount', $x); //->with('success', );
            }
        } else {
            flash()->error('Product Discount(s) Could not be Saved');
            return redirect()->route('inventory.product.discount')->with('data', $this->data);
        }
    }

    public function setProductPrice() {
        $this->data['price'] = InventoryProductPrice::all();
        $this->data['products'] = InventoryProducts::all();
        return view('inventory::products.set_product_price')->with('data', $this->data);
    }

    public function delProductPrice() {
        InventoryProductPrice::find($this->request->id)->delete();
        $this->data['products'] = InventoryProducts::all();
        $this->data['price'] = InventoryProductPrice::all();
        flash('Item price deleted successfully');
        return redirect()->route('inventory.product.price')->with('data', $this->data);
    }

    public function editProductPrice() {
        if (InventoryFunctions::updateProdPrice($this->request)) {
            flash('Item price(s) updated successfully');
            return redirect()->route('inventory.product.price')->with('data', $this->data);
        }
        $this->data['products'] = InventoryProducts::all();
        $this->data['price'] = InventoryProductPrice::all();
        flash()->warning('Something went wrong, please try again');
        return redirect()->route('inventory.product.price')->with('data', $this->data);
    }

    public function saveItemPrices() {
        $this->data['products'] = InventoryProducts::all();
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::saveProdPrice($this->request)) {
                $x = \Session::get('last_order');
                flash('Product Price(S) Saved');
                return redirect()->route('inventory.product.price', $x); //->with('success',);
            }
        } else {
            flash()->error('Product Price(s) Could not be Saved');
            return redirect()->route('inventory.product.price')->with('data', $this->data);
        }
    }

    public function setCategoryPrice() {
        $this->data['price'] = InventoryCategoryPrice::all();
        $this->data['product_categories'] = InventoryCategories::all();
        return view('inventory::set_category_prices')->with('data', $this->data);
    }

    public function delCategoryPrice() {
        InventoryCategoryPrice::find($this->request->id)->delete();
        $this->data['price'] = InventoryCategoryPrice::all();
        $this->data['product_categories'] = InventoryCategories::all();
        flash('Category price deleted');
        return view('inventory::set_category_prices')
                        ->with('data', $this->data);
    }

    public function saveCategoryPrice() {
        $this->data['product_categories'] = InventoryCategories::all();
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::saveCatPrice($this->request)) {
                $x = \Session::get('last_order');
                flash('Category Price(S) Saved');
                return redirect()->route('inventory.category.price', $x); //->with('success');
            }
        } else {
            flash()->error('Category Price(s) Could not be Saved');
            return redirect()->route('inventory.category.price')->with('data', $this->data);
        }
    }

    public function approveLPO($id) {
        $this->data['order'] = InventoryPurchaseOrders::findOrFail($id);
        if (InventoryFunctions::approveLPO($id)) {
            flash('LPO Approved Successfully');
            return redirect()->back();
        } else {
            flash()->error('LPO Could not be Approved, please try again');
            return redirect()->back();
        }
    }

    public function receive_goods() {
        $this->data['lpos'] = InventoryPurchaseOrders::approved()->get();
        $this->data['deliveries'] = InventoryBatch::all();
        return view('inventory::receive_goods')->with('data', $this->data);
    }

    public function grns() {
        $this->data['deliveries'] = InventoryBatch::all();
        return view('inventory::grns')->with('data', $this->data);
    }

    public function receive_lpo($id) {
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::receive_from_lpo($this->request)) {
                $batch_id = \Session::get('last_receive');
                flash('Order Goods have been Received Successfully');
                return redirect()->route('inventory.purchase_details', $batch_id);
            }
        }
        $this->data['deliveries'] = InventoryBatch::all();
        $this->data['order'] = InventoryPurchaseOrders::findOrFail($id);
        return view('inventory::receive_lpo_goods')->with('data', $this->data);
    }

    public function purchase_details(InventoryBatch $batch) {
        $this->data['batch'] = $batch;
        return view('inventory::after_receive')
                        ->with('data', $this->data);
    }

    public function receive_direct() {
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::receive_goods_direct($this->request)) {
                $batch_id = \Session::get('last_receive');
                flash('Order Goods have been Received Successfully');
                return redirect()->route('inventory.purchase_details', $batch_id);
            }
        }
        $this->data['supplier'] = InventorySupplier::find($this->request->supplier);
        return view('inventory::receive_direct_goods')->with('data', $this->data);
    }

    public function batch_details($id) {
        $this->data['del'] = InventoryBatch::find($id);
        $this->data['accounts'] = BankAccount::all();
        $purchases = InventoryBatchPurchases::query();
        $this->data['items'] = $purchases->where('batch', '=', $id)->get();
        return view('inventory::batch_details')->with('data', $this->data);
    }

}
