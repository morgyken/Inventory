<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryProductMarkup
 *
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @mixin \Eloquent
 */
class InventoryProductMarkup extends Model {

    protected $fillable = ['product', 'markup'];
    public $table = 'inventory_product_markup';

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
