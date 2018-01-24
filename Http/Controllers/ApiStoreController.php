<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\InventoryProductPrice;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\StoreDepartment;
use Ignite\Inventory\Entities\StoreProducts;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ApiStoreController extends Controller
{
    public function products()
    {
        $found = collect();

        $term = request('term')['term'];

        $stores = StoreDepartment::with(['stores'])->whereIn('name',  request('departments'))
                                 ->get()->pluck('stores')->flatten()->pluck('id');

        if (!empty($term))
        {
            if (request()->has('shop'))
            {
                //Get for shop only
                $found = InventoryProducts::with(['prices' => function ($query) {
                }])->with(['stocks' => function ($query) {
                }])->where('name', 'like', "%$term%")->whereHas('categories', function ($qc) {
                    $qc->whereName('Shop');
                })->get();

            }
            else
            {
                $storeProducts = StoreProducts::whereHas('product', function($query) use($term){

                    $query->where('name', 'like', "%$term%");

                })->with(['store', 'product'])->whereIn('store_id', $stores)->get();

                $build = $storeProducts->map(function($storage){

                    $product = $storage->product;
                    $store = $storage->store;
                    $batchp = InventoryBatchPurchases::whereProduct($product->id)
                            ->whereActive(TRUE)
                            ->first();
                    $itemPrices = InventoryProductPrice::where('product', $product->id)->get();
                    $active_price = 0.00;
                    foreach ($itemPrices as $product) {
                        if ($product->price > $active_price) {
                            $active_price = $product->price;
                        }
                    }

                    $expiry = empty($batchp->expiry_date) ? '' : ' |expiry: ' . $batchp->expiry_date;
                    $stock_text = $storage->quantity == 0 ? '  Out of stock' : $storage->quantity . ' in stock';
                    $strngth_text = empty($product->strength) ? '' : ' | ' . $product->strength . $product->units->name;

                    return [
                        'text' => $storage->product->name . '  - ' . $stock_text . $strngth_text . $expiry . "( " . $store->name . " )",
                        'id' => $product->id,
                        'store' => $store->id,
                        'batch' => empty($batchp->batch) ? 0 : $batchp->batch,

//                        'cash_price' => ($product->categories->cash_markup + 100) / 100 * $active_price, //$item->prices->credit_price
//
//                        'credit_price' => ($product->categories->credit_markup + 100) / 100 * $active_price,

                        'o_price' => $active_price,
                        'available' => $storage->quantity,
                        'disabled' => $storage->quantity == 0 ? true : false,
                    ];

                });
            }
        }

        return response()->json(['results' => $build]);
    }
}
