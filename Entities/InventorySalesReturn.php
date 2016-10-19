<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventorySalesReturn
 *
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @mixin \Eloquent
 */
class InventorySalesReturn extends Model {

    protected $fillable = [];
    public $table = 'inventory_sales_returns';

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
