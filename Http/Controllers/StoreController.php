<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Entities\InternalOrder;
use Ignite\Inventory\Entities\Store;
use Ignite\Inventory\Repositories\InventoryRepository;
use Illuminate\Http\Request;

class StoreController extends AdminBaseController
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

    public function startOrder()
    {
        $this->data['orders'] = InternalOrder::all();
        $this->data['stores'] = Store::all();
        return view('inventory::store.internal_orders', ['data' => $this->data]);
    }

    public function viewOrders($id = null)
    {
        if ($id) {
            $this->data['order'] = InternalOrder::find($id);
            return view('inventory::store.order_details', ['data' => $this->data]);
        }
        $this->data['orders'] = InternalOrder::all();
        return view('inventory::store.internal_orders_all', ['data' => $this->data]);
    }

    public function newOrders()
    {
        if ($id = $this->inventoryRepository->saveInternalOrder()) {
            flash('Internal Order placed successfully');
            return redirect()->route('inventory.store.view_orders', $id);
        }
        return redirect()->route('inventory.store.view_orders');
    }

    public function saveStore()
    {
        $store = new Store;
        $store->name = $this->request->name;
        $store->description = $this->request->desc;
        $store->save();
        flash('Store saved', 'success');
        return redirect()->route('inventory.store.stores');
    }

    public function stores($id = null)
    {
        $this->data['stores'] = Store::all();
        return view('inventory::store.stores', ['data' => $this->data]);
    }

    public function dispatchItems($id = null)
    {
        if ($id) {
            $this->data['order'] = InternalOrder::find($id);
            return view('inventory::store.dispatch_details', ['data' => $this->data]);
        }
        $this->data['orders'] = InternalOrder::whereStatus(0)->get();
        return view('inventory::store.dispatch_orders', ['data' => $this->data]);
    }

    public function saveDispatch()
    {
        $dis = $this->inventoryRepository->dispatchInternal();
        flash("Inventory Dispatched");
        return redirect()->route('inventory.store.dispatch', $dis);
    }
}
