<?php
namespace Ignite\Inventory\Repositories;

use Ignite\Inventory\Entities\InternalOrder;
use Ignite\Inventory\Entities\Store;

class OrdersRepository
{
    /*
     * Returns all the orders made by a store or all stores
     */
    public function getOrders($id)
    {
        $orders = InternalOrder::where('dispatching_store', $id)
                            ->orWhere('requesting_store', $id)
                            ->get();

        $ordersMade = $orders->filter(function($order) use($id){

            return $order->requesting_store == $id;

        });

        $ordersReceived = $orders->filter(function($order) use($id){

            return $order->dispatching_store == $id;

        });

        return compact('ordersMade', 'ordersReceived');
    }



    /*
     * Returns the stores that are supposed to dispatch to a certain store
     */
    public function getDispatchingStores($store)
    {
        if($store->parentStore)
        {
           return [ $store->parentStore->id => $store->parentStore->name ];
        }

        return Store::all()->pluck('name', 'id');
    }
}