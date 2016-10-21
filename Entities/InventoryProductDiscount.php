<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryProductDiscount
 *
 * @property integer $id
 * @property integer $product
 * @property float $discount
 * @property boolean $active
 * @property string $end_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductDiscount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductDiscount whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductDiscount whereDiscount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductDiscount whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductDiscount whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductDiscount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductDiscount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryProductDiscount extends Model {

    protected $fillable = ['product', 'discount', 'end_date'];
    public $table = 'inventory_product_discounts';

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
