<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Inventory\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryStockAdjustment
 *
 * @property integer $id
 * @property integer $product
 * @property integer $quantity
 * @property string $method
 * @property string $type
 * @property string $reason
 * @property string $approved
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereReason($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereApproved($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereUpdatedAt($value)
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

}
