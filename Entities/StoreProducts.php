<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class StoreProducts extends Model
{
    protected $table = "inventory_store_products";

    protected $guarded = [ 'id' ];

    /*
     * Relationship between a store product and the product itself
     */
    public function product()
    {
        return $this->belongsTo(InventoryProducts::class, 'product_id');
    }

    /*
     * Relationship between a store product and the store itself
     */
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
