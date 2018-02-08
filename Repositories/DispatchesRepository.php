<?php
/**
 * Created by PhpStorm.
 * User: kisiara
 * Date: 13/01/2018
 * Time: 16:09
 */

namespace Ignite\Inventory\Repositories;

use Ignite\Inventory\Entities\InternalOrder;
use Ignite\Inventory\Entities\InternalOrderDispatch;
use Ignite\Inventory\Entities\StoreProducts;

class DispatchesRepository
{
    public function dispatch($storeId, $orderId)
    {
        $data = collect(request('dispatch'))->where('dispatched', '>', 0)->toArray();

        foreach($data as $dispatch)
        {
            $record = InternalOrderDispatch::create($dispatch);

            $productId = $record->detail->product->id;

            $product = StoreProducts::firstOrCreate(['product_id' => $productId, 'store_id' => $storeId]);

            if($product->quantity < $dispatch['dispatched'])
            {
                break;
            }

            $product->quantity = $product->quantity - $dispatch['dispatched'];

            $product->save();
        }
    }
}