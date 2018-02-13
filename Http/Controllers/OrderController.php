<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Repositories\OrdersRepository;
use Ignite\Inventory\Repositories\StoresRepository;
use Ignite\Inventory\Library\OrderTrail;
use Illuminate\Support\Facades\Auth;

class OrderController extends AdminBaseController
{
    protected $repo, $storeRepo;

    /*
     * Inject any necessary dependencies
     */
    public function __construct(OrdersRepository $repo, StoresRepository $storeRepo)
    {
        parent::__construct();

        $this->repo = $repo;

        $this->storeRepo = $storeRepo;
    }

    /*
     * Show the orders made by a store
     */
    public function index($storeId)
    {
        $store = $this->storeRepo->find($storeId);

        $dispatchingStores = $this->repo->getDispatchingStores($store);

        $orders = $store->orders()->latest()->get();

        $orders = $orders->map(function($order){
            return [
                'id' => $order->id,
                'name' => $order->users->profile->fullName,
                'dispatching' => $order->dispatchingStore->name,
                'status' => $this->isDispatched($order),
                'created_at' => $order->created_at,
                'cancelled' => $order->cancelled,
            ];
        });

        $data = compact('store', 'dispatchingStores', 'orders');

        return view('inventory::store.orders.orders_made', $data);
    }

    /*
     * Store an order that has been made
     */
    public function store($storeId)
    {
        $store = $this->storeRepo->find($storeId);

        $this->repo->create($store);

        flash('Your order has been successfully sent', 'success');

        return redirect()->back();
    }

    /*
     * Show the orders made by a store
     */
    public function received($storeId)
    {
        $store = $this->storeRepo->find($storeId);

        $orders = $store->received()->where('cancelled', false)->orderBy('created_at')->get();

        return view('inventory::store.orders.orders_received', compact('store', 'orders'));
    }

    /*
     * Show the form to receive orders that have been dispatched
     */
    public function edit($storeId, $orderId)
    {
        $order = $this->repo->find($orderId);

        $store = $order->requestingStore;

        return view('inventory::store.orders.receive_orders', compact('order', 'store'));
    }

    /*
     * Show an order and the trail with which products were received
     */
    public function show($storeId, $orderId)
    {
        $order = $this->repo->find($orderId);

        $store = $this->storeRepo->find($storeId);

        $details = $order->details->transform(function($detail){

            return [
                'product' => $detail->product->name,

                'quantity' => $detail->quantity,

                'trail' => (new OrderTrail($detail))->trail(),
            ];

        });

        return view('inventory::store.orders.order_details', compact('order', 'details', 'store'));
    }

    /*
     * Delete an order from the system
     */
    public function delete()
    {
        $order = $this->repo->find(request('order_id'));

        $order->update([
            'cancelled' => true,
            'cancelled_by' => Auth::id(),
            'cancellation_reason' => request('cancel_reason')
        ]);

        flash('Your order has been cancelled successfully', 'success');

        return redirect()->back();
    }

    /*
     * Checks if an item has been completely dispatched
     */
    public function isDispatched($order)
    {
        if($order->cancelled)
        {
            return "Cancelled";
        }
        
        foreach($order->details as $detail)
        {
            if($detail->quantity != $detail->dispatched)
            {
                return "Pending";
            }
        }

        return "Dispatch Completed";
    }
}
