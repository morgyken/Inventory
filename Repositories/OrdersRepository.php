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

            $details = request()->except(['items']);

            $details['delivery_date'] = carbonDate($details['delivery_date']);

            $order = $store->orders()->create($details);

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