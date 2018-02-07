<?php

namespace Ignite\Inventory\Http\Controllers;

use Carbon\Carbon;
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

        $stores = StoreDepartment::with(['stores'])->where('id',  request('clinic'))
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

                })->with(['store', 'product.stocks', 'product.prices'])->whereIn('store_id', $stores)->get();


                $build = $storeProducts->map(function($storeProduct){

                    $storeId = $storeProduct->store_id;

                    $product = $storeProduct->product;

                    $batchp = InventoryBatchPurchases::whereProduct($product->id)->whereActive(TRUE)->first();

                    $this->data['item_prices'] = InventoryProductPrice::query()->where('product', '=', $product->id)->get();

                    $active_price = 0.00;

                    foreach ($this->data['item_prices'] as $productPrice)
                    {
                        if ($productPrice->price > $active_price)
                        {
                            $active_price = $productPrice->price;
                        }
                    }

                    $expiry = empty($batchp->expiry_date) ? '' : ' |expiry: ' . $batchp->expiry_date;
                    $stock_text = $storeProduct->quantity == 0 ? '  Out of stock' : $storeProduct->quantity . ' in stock';
                    $strngth_text = empty($product->strength) ? '' : ' | ' . $product->strength . $product->units->name;

                    return [
                        'text' => $product->name . '  - ' . $stock_text . $strngth_text . $expiry . "( " . $storeProduct->store->name . " )",
                        'id' => $product->id,
                        'store' => $storeId,
                        'batch' => empty($batchp->batch) ? 0 : $batchp->batch,
                        'cash_price' => ($product->categories->cash_markup + 100) / 100 * $active_price, //$item->prices->credit_price
                        'credit_price' => ($product->categories->credit_markup + 100) / 100 * $active_price,
                        'o_price' => $active_price,
                        'available' => $storeProduct->quantity,
                        'disabled' => $storeProduct->quantity == 0 ? true : false,
                    ];

                });

                return response()->json(['results' => $build]);
            }
        }

//        return response()->json(['results' => $build]);
    }

    public function orderProducts()
    {

        $term = request('term')['term'];
        $new_array = [];
        if (!empty($term)) {
            /** @var InventoryProducts[] $found */
            $found = InventoryProducts::with(['prices' => function ($query) {
            }, 'taxgroups'])
                //  ->select('id', 'name', 'strength')
                ->where('name', 'like', "%$term%")->get();
            foreach ($found as $item) {
                if($item->created_at >= Carbon::parse("6th February 2018"))
                {
                    $str = $item->strength ? '(' . $item->strength . ' ' . $item->units->name . ')' : '';
                    $text = $item->name . ' ' . $str;
                    $new_array[] = [
                        'text' => $text,
                        'id' => $item->id,
                        'tax' => $item->taxgroups ? $item->taxgroups->rate : 0,
//                    'disabled' => true
                    ];
                }
            }
        }
        return response()->json(['results' => $new_array]);

    }
}
