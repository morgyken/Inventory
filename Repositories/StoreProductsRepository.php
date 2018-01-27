<?php
namespace Ignite\Inventory\Repositories;

use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\StoreProducts;

class StoreProductsRepository
{
    /*
     * Returns all the definitions of the departments from the database
     */
    public function all()
    {
        return StoreProducts::all();
    }

    /*
     * Updates the tables as necessary in order to allow easier store management
     */
    public function update($storeId, $products)
    {
        foreach ($products as $product)
        {
            $storeProduct = StoreProducts::firstOrNew([
                'store_id' => $storeId,
                'product_id' => $product->products->id
            ]);

            $storeProduct->quantity = $storeProduct->quantity + $product->quantity;

            $storeProduct->selling_price = $product->products->cash_price;

            $storeProduct->insurance_price = $product->products->insurance_p;

            $storeProduct->save();
        }
    }

    /*
     * Populate the store with the necessary items
     */
    public function populate($store)
    {
        $products = InventoryProducts::all();

        $population = array();

        if(is_null($store->department) and $store->main_store)
        {
            foreach($products as $product)
            {
                $population[$product->id] = [
                    'quantity' => $product->stocks ? $product->stocks->quantity : 0,
                ];
            }
        }

        if($store->department and $store->department->name == "Pharmacy")
        {
            $products = $products->filter(function($product){
                            return $product->categories && $product->categories->name == 'Drugs';
                        });

            foreach($products as $product)
            {
                 $population[$product->id] =[
                     'quantity' =>  $product->stocks ? $product->stocks->quantity : 0
                 ];
            }
        }

        $store->products()->attach($population);
    }
}