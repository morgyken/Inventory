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
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Inventory\Library\InventoryFunctions;
use Illuminate\Http\Request;
use Ignite\Inventory\Entities\InventorySalesReturn;
use Ignite\Inventory\Entities\InventoryDispensing;
use Ignite\Settings\Entities\Schemes;

class SalesController extends AdminBaseController {

    protected $request;

    public function __construct(Request $request) {
        parent::__construct();
        $this->request = $request;
    }

    public function shopfront($id = null) {
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::record_sales($this->request, $id)) {
                $receipt = \Session::get('receipt_id');
                flash('Transaction completed');
                return redirect()->route('inventory.receipt', $receipt);
            }
        }
        $this->data['schemes'] = Schemes::all();
        return view('inventory::shop.shop')->with('data', $this->data);
    }

    /**
     * @todo Record the sales details
     * @param type $id
     * @return type
     */
    public function receipt($id) {
        $this->data['sales'] = InventoryBatchProductSales::find($id);
        return view('inventory::shop.receipt_preview')->with('data', $this->data);
    }

    public function receipts() {
        $this->data['records'] = InventoryBatchProductSales::all();
        return view('inventory::sales_receipts')->with('data', $this->data);
    }

    public function return_goods() {
        if ($this->request->isMethod('post')) {
            if (InventoryFunctions::sales_return($this->request)) {
                return redirect()->back()->with('success', 'Transaction Successful');
            }
        }
        $this->data['batch_sales'] = InventoryBatchProductSales::all();
        $this->data['dispenses'] = InventoryDispensing::select('*')->groupby('product')->get();
        $this->data['returns'] = InventorySalesReturn::all();
        return view('inventory::shop.goods_return')->with('data', $this->data);
    }

}
