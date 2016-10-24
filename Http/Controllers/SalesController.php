<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Inventory\Repositories\InventoryRepository;
use Ignite\Settings\Entities\Schemes;
use Illuminate\Http\Request;
use Ignite\Inventory\Entities\InventorySalesReturn;
use Ignite\Inventory\Entities\InventoryDispensing;
use Ignite\Inventory\Entities\InventoryInsuranceDetails;

class SalesController extends AdminBaseController {

    /**
     * @var InventoryRepository
     */
    protected $inventoryRepository;

    /**
     * SalesController constructor.
     * @param InventoryRepository $repository
     * @param Request $request
     */
    public function __construct(InventoryRepository $repository, Request $request) {
        parent::__construct();
        $this->inventoryRepository = $repository;
        $this->request = $request;
    }

    public function shopfront($id = null) {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->record_sales($id)) {
                $receipt = session('receipt_id');
                flash('Transaction completed');
                return redirect()->route('inventory.receipt', $receipt);
            }
        }
        $this->data['schemes'] = Schemes::all();
        return view('inventory::shop.shop', ['data' => $this->data]);
    }

    public function shopfront_credit($id = null) {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->record_sales($id)) {
                $receipt = session('receipt_id');
                flash('Bill placed successfully');
                return redirect()->route('inventory.receipt', $receipt);
            }
        }
        return view('inventory::shop.credit', ['data' => $this->data]);
    }

    /**
     * @todo Record the sales details
     * @param type $id
     * @return type
     */
    public function clients($id = null) {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->save_client($id)) {
                flash('Client Saved.. thank you');
                return redirect()->route('inventory.clients.credit', null);
            }
        }
        if ($this->request->id > 0) {
            $this->data['ins'] = InventoryInsuranceDetails::find($this->request->id);
        }
        return view('inventory::shop.credit_user', ['data' => $this->data]);
    }

    /**
     * @todo Record the sales details
     * @param type $id
     * @return type
     */
    public function show_clients($id = null) {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->save_client($id)) {
                flash('Client Saved.. thank you');
                return redirect()->route('inventory.clients.credit', null);
            }
        }
        $this->data['ins'] = InventoryInsuranceDetails::all();
        return view('inventory::clients', ['data' => $this->data]);
    }

    public function purge_client($id = null) {
        if ($this->inventoryRepository->purge_client($id)) {
            flash('client information deleted.. thank you');
            return redirect()->route('inventory.clients.credit', null);
        }
        return redirect()->back();
    }

    /**
     * @todo Record the sales details
     * @param type $id
     * @return type
     */
    public function receipt($id) {
        $this->data['sales'] = InventoryBatchProductSales::find($id);
        return view('inventory::shop.receipt_preview', ['data' => $this->data]);
    }

    public function receipts() {
        $this->data['records'] = InventoryBatchProductSales::all();
        return view('inventory::sales_receipts', ['data' => $this->data]);
    }

    public function return_goods() {
        if ($this->request->isMethod('post')) {
            if ($this->inventoryRepository->sales_return()) {
                flash("Transaction Successful");
                return back();
            }
        }
        $this->data['batch_sales'] = InventoryBatchProductSales::all();
        $this->data['dispenses'] = InventoryDispensing::groupBy('product')->get();
        $this->data['returns'] = InventorySalesReturn::all();
        return view('inventory::shop.goods_return', ['data' => $this->data]);
    }

}
