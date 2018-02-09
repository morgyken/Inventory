<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class StoreStockAdjustment extends Model
{
    protected $guarded = ['id'];

    protected $table = "inventory_store_stock_adjustments";

    /*
     * Relationship between the user and stock adjustment
     */
    public function facilitator()
    {

    }

    /*
     * Relationship between store product
     */
    public function stock()
    {

    }

}
