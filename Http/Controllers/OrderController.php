<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Ignite\Inventory\Repositories\OrdersRepository;
use Ignite\Inventory\Entities\Store;
use Ignite\Inventory\Repositories\InventoryRepository;

class OrderController extends AdminBaseController
{
    protected $repo;

    public function __construct(OrdersRepository $repo, InventoryRepository $inventoryRepository)
    {
        parent::__construct();

        $this->repo = $repo;

        $this->inventoryRepository = $inventoryRepository;
    }

    /*
     * Store an order
     */
    public function store()
    {
        if ($id = $this->inventoryRepository->saveInternalOrder()) {
            flash('Internal Order placed successfully');
            return redirect()->route('inventory.store.view_orders', $id);
        }

        return redirect()->route('inventory.store.view_orders');
    }

    /*
     * Shows all the orders made by a store and to which store
     */
    public function ordersMade($id)
    {
        $storeOrders = $this->repo->getOrders($id);

        $store = Store::find($id);

        $stores = $this->repo->getDispatchingStores($store);

        $data = array_merge(compact('store', 'stores'), $storeOrders);

        return view('inventory::store.orders.orders_made', $data);
    }

    /*
     * Shows orders received by store
     */
    public function ordersReceived($id)
    {
        $storeOrders = $this->repo->getOrders($id);

        $store = Store::find($id);

        $data = array_merge(compact('store'), $storeOrders);

        return view('inventory::store.orders.orders_received', $data);
    }

    /*
     * Shows view to received orders
     */
    public function receiveOrders($id)
    {
        $store = Store::find($id);

        $orders = InternalOrder::whereIn('status', [1, 2])
                               ->where('requesting_store', $store->id)->get();

        return view('inventory::store.orders.receive_orders', compact('orders'));
    }


}
