<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryProductMarkup
 *
 * @property int $id
 * @property int $product
 * @property float $markup
 * @property int $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductMarkup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductMarkup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductMarkup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductMarkup whereMarkup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductMarkup whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductMarkup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryProductMarkup extends Model {

    protected $fillable = ['product', 'markup'];
    public $table = 'inventory_product_markup';

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
