<?php
namespace Ignite\Inventory\Repositories;

use Ignite\Inventory\Entities\InternalOrderDetails;
use Ignite\Inventory\Entities\InternalReceivedOrders;
use Ignite\Inventory\Entities\Store;
use Ignite\Inventory\Entities\StoreProducts;
use Illuminate\Support\Facades\DB;

class OrdersReceivingRepository
{
    /*
     * Receive items from the dispatched list
     */
    public function create($storeId, $orderId)
    {
//        dd(request('receive'));

        foreach(request('receive') as $item)
        {
            if($item['received'] > 0 or $item['rejected'] > 0)
            {
                $orderDetail = InternalOrderDetails::find($item['order_detail_id']);

                $product = $orderDetail->product;

                $productId = $product->id;

                $cashPrice = $orderDetail->sellingP;

                $insurancePrice = $orderDetail->insuranceP;

                $receivingStore = $orderDetail->order->requesting_store;

                InternalReceivedOrders::create($item);

                $record = StoreProducts::firstOrCreate(['product_id' => $productId, 'store_id' => $receivingStore]);

                $record->quantity = $record->quantity + $item['received'];

                $record->selling_price = $record->selling_price != 0 ?: $cashPrice;

                $record->insurance_price = $record->insurance_price != 0 ?: $insurancePrice;

                $record->save();
            }
        }
    }
}