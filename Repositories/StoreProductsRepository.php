<?php
namespace Ignite\Inventory\Repositories;

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
     * Updates the tables as neccessary in order to allow easier store management
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
}