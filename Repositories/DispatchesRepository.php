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
    public function dispatch()
    {
        $data = collect(request('dispatch'))->where('dispatched', '>', 0)->toArray();

        foreach($data as $dispatch)
        {
            $dispatch['created_at'] = $dispatch['updated_at'] = now();

            $record = new InternalOrderDispatch($dispatch);

            $record->save();

            $storeProduct = StoreProducts::firstOrNew([
                'product_id' => $record->detail->product->id, 'store_id' => $record->dispatched_by
            ]);

            $storeProduct->quantity = $storeProduct->quantity - $dispatch['dispatched'];

            $storeProduct->save();
        }

    }
}