<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryProductDiscount
 *
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @mixin \Eloquent
 */
class InventoryProductDiscount extends Model {

    protected $fillable = ['product', 'discount', 'end_date'];
    public $table = 'inventory_product_discounts';

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
