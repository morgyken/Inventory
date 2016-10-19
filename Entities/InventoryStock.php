<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryStock
 *
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @mixin \Eloquent
 */
class InventoryStock extends Model {

    protected $guarded = [];
    public $table = 'inventory_stocks';

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
