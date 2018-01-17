<?php
namespace Ignite\Inventory\Repositories;

use Ignite\Inventory\Entities\InternalReceivedOrders;
use Ignite\Inventory\Entities\Store;
use Illuminate\Support\Facades\DB;

class OrdersReceivingRepository
{
    /*
     * Receive items from the dispatched list
     */
    public function create()
    {
        $items = [];

        foreach(request('receive') as $receive)
        {
            $receive['created_at'] = $receive['updated_at'] = now();

            array_push($items, $receive);
        }

        InternalReceivedOrders::insert($items);
    }
}