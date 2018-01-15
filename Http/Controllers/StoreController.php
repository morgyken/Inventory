<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Entities\InternalOrder;
use Ignite\Inventory\Entities\Store;
use Ignite\Inventory\Repositories\InventoryRepository;
use Illuminate\Http\Request;
use Ignite\Inventory\Repositories\StoresRepository;

class StoreController extends AdminBaseController
{
    /**
     * @var Request Incoming HTTP request
     */
    protected $request, $repo;

    /**
     * @var InventoryRepository
     */
    protected $inventoryRepository;

    public function __construct(Request $request, InventoryRepository $inventoryRepository, StoresRepository $repo)
    {
        parent::__construct();
        $this->request = $request;
        $this->inventoryRepository = $inventoryRepository;
        $this->repo = $repo;
    }

    /*
    * Lists all the stores as well as the creation of one
    */
    public function create()
    {
        $stores = $this->repo->all();

        return view('inventory::store.create', compact('stores'));
    }

    /*
    * Lists all the stores as well as the creation of one
    */
    public function edit($id)
    {
        $stores = $this->repo->all();

        $store = $this->repo->find($id);

        return view('inventory::store.edit', compact('stores', 'store'));
    }

    /*
    * Lists all the stores as well as the creation of one
    */
    public function show($id)
    {
        $store = $this->repo->find($id);

        return view('inventory::store.show', compact('store'));
    }

    /*
     * Persist a store into the database
     */
    public function store()
    {
        $this->repo->create();

        flash('Store saved', 'success');

        return redirect()->back();
    }

    /*
     * Persist a store into the database
     */
    public function update($id)
    {
        $this->repo->update($id);

        flash('Store updated', 'success');

        return redirect()->back();
    }

    /*
     * Persist a store into the database
     */
    public function delete($id)
    {
        $this->repo->delete($id);

        flash('Store deleted', 'success');

        return redirect()->route('inventory.store.create');
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
        $this->data['orders'] = InternalOrder::whereIn('status', [0, 1])->get();
        return view('inventory::store.dispatch_orders', ['data' => $this->data]);
    }

    public function saveDispatch()
    {
        $dis = $this->inventoryRepository->dispatchInternal();
        flash('Items Dispatched', 'success');
        return redirect()->route('inventory.store.dispatch', $dis);
    }

    public function receiveItems($id = null)
    {
        if ($id) {
            $this->data['order'] = InternalOrder::find($id);
            return view('inventory::store.receive_details', ['data' => $this->data]);
        }
        $this->data['orders'] = InternalOrder::whereIn('status', [1, 2])->get();
        return view('inventory::store.receive_orders', ['data' => $this->data]);
    }

    public function saveReceive()
    {
        $dis = $this->inventoryRepository->saveReceived();
        flash('Items Received', 'success');
        return redirect()->route('inventory.store.receive', $dis);
    }
}
