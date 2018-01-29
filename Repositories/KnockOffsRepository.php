<?php
namespace Ignite\Inventory\Repositories;

use DB;
use Ignite\Inventory\Entities\StoreKnockOff;
use Ignite\Inventory\Entities\StoreProducts;

class KnockOffsRepository
{
    public function create($storeId)
    {
        DB::transaction(function() use($storeId){

            foreach(request('items') as $item)
            {
                $storeProduct = StoreProducts::where('store_id', $storeId)
                                             ->where('product_id', $item['product_id'])->first();

                $newQuantity = $storeProduct->quantity - $item['quantity'];

                $storeProduct->quantity = $newQuantity <= 0 ? 0 : $newQuantity;

                $item['knocked_by'] = request('knocked_by');

                StoreKnockOff::create($item);

                $storeProduct->save();
            }
        });
    }
}