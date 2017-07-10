<?php

namespace Ignite\Inventory\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryStockAdjustment
 *
 * @property int $id
 * @property int $product
 * @property int $opening_qty
 * @property int $quantity
 * @property int $new_stock
 * @property string $method
 * @property string $type
 * @property string $reason
 * @property string|null $approved
 * @property int|null $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $closing
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read \Ignite\Users\Entities\User|null $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereNewStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereOpeningQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereUser($value)
 * @mixin \Eloquent
 */
class InventoryStockAdjustment extends Model {

    protected $fillable = [];
    public $table = 'inventory_stock_adjustments';

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

    public function getClosingAttribute() {
        if ($this->method == '+') {
            return $this->opening_qty + $this->quantity;
        }
        return $this->opening_qty - $this->quantity;
    }

}
