<?php
/**
 * Created by PhpStorm.
 * User: kisiara
 * Date: 13/01/2018
 * Time: 16:09
 */

namespace Ignite\Inventory\Repositories;

use Ignite\Inventory\Entities\InternalOrderDispatch;
use Ignite\Inventory\Entities\StoreProducts;

class DispatchesRepository
{
    public function dispatch($id)
    {
        $data = collect(request('dispatch'))->where('dispatched', '>', 0)->toArray();

        foreach($data as $dispatch)
        {
            $record = $this->dispatchItem($dispatch);

            $this->reduceQuantity($record->detail->product->id, $id, $record->dispatched_by, $dispatch['dispatched']);
        }

    }

    private function dispatchItem($dispatch)
    {
        $dispatch['created_at'] = $dispatch['updated_at'] = now();

        $record = new InternalOrderDispatch($dispatch);

        $record->save();

        return $record;
    }

    private function reduceQuantity($productId, $storeId, $quantityDispatched)
    {
        $product = StoreProducts::where('product_id', $productId)
                                ->where('store_id', $storeId)->first();

        $product->quantity = $product->quantity - $quantityDispatched;

        $product->save();
    }
}