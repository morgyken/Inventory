<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Repositories\OrdersRepository;
use Ignite\Inventory\Repositories\StoresRepository;
use Ignite\Inventory\Library\OrderTrail;

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

        $data = compact('store', 'dispatchingStores');

        return view('inventory::store.orders.orders_made', $data);
    }

    /*
     * Store an order that has been made
     */
    public function store($storeId)
    {
        $store = $this->storeRepo->find($storeId);

        $this->repo->create($store);

        flash('Your order has been succefully sent', 'success');

        return redirect()->back();
    }

    /*
     * Show the orders made by a store
     */
    public function received($storeId)
    {
        $store = $this->storeRepo->find($storeId);

        return view('inventory::store.orders.orders_received', compact('store'));
    }

    /*
     * Show the form to receive orders that have been dispatched
     */
    public function edit($id)
    {
        $order = $this->repo->find($id);

        $store = $order->dispatchingStore;

        return view('inventory::store.orders.receive_orders', compact('order', 'store'));
    }

    /*
     * Show an order and the trail with which products were received
     */
    public function show($id)
    {
        $order = $this->repo->find($id);

        $details = $order->details->transform(function($detail){

            return [
                'product' => $detail->product->name,

                'quantity' => $detail->quantity,

                'trail' => (new OrderTrail($detail))->trail(),
            ];

        });

        return view('inventory::store.orders.order_details', compact('order', 'details'));
    }

//    private function trail($detail)
//    {
//        $merged = array_merge($detail->dispatch->toArray(), $detail->received->toArray());
//
//        collect($merged)->transform(function($trail){
//
//            dd($trail);
//
//        });
//
////        dd($detail->dispatch->concat($detail->received));
//    }
}
