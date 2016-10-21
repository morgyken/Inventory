<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryStock
 *
 * @property integer $id
 * @property integer $product
 * @property integer $quantity
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStock whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStock whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStock whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStock whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryStock extends Model {

    protected $guarded = [];
    public $table = 'inventory_stocks';

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
