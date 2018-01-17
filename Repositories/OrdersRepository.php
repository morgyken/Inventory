<?php
namespace Ignite\Inventory\Repositories;

use Ignite\Inventory\Entities\InternalOrder;
use Ignite\Inventory\Entities\Store;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class OrdersRepository
{
    /*
     * Return an order from the database
     */
    public function find($orderId)
    {
        return InternalOrder::find($orderId);
    }

    /*
     * Make an order from a store
     */
    public function create($store)
    {
        DB::transaction(function () use ($store) {

            $orderDetails = request()->except(['items']);

            $orderDetails['author'] = Auth::id();

            $orderDetails['deliver_date'] = $orderDetails['deliver_date'] ? Carbon::parse($orderDetails['deliver_date']) : null;

            $order = $store->orders()->create($orderDetails);

            $order->details()->createMany(request('items'));

        });
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

        return Store::where('id', '!=', $store->id)->get()->pluck('name', 'id');
    }
}