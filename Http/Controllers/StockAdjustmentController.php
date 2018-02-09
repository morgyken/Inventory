<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Inventory\Entities\StoreProducts;
use Ignite\Inventory\Entities\StoreStockAdjustment;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    /*
     * Create a new stock adjustment record and persist it into the database
     */
    public function create()
    {
        if(request('quantity') < 0)
        {
            flash('Sorry! You cannot have items that are negative', 'error');

            return redirect()->back();
        }

        $stockAdjustment = DB::transaction(function(){

            $storeProduct = StoreProducts::where('product_id', request('product_id'))->where('store_id', request('store_id'))->first();

            $newQuantity = request('quantity');

            $oldQuantity = $storeProduct->quantity;

            $storeProduct->quantity = $newQuantity;

            $storeProduct->save();

            $adjustment = [
                'store_product_id' => $storeProduct->id,
                'previous_quantity' => $oldQuantity,
                'new_quantity' => $newQuantity,
                'reason' => request('reason'),
                'user_id' => request('user_id'),
            ];

            return StoreStockAdjustment::create($adjustment);
        });

        if($stockAdjustment)
        {
            flash("You have successfully adjusted the stock", "success");
        }

        return redirect()->back();
    }
}
