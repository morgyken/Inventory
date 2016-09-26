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
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryStockAdjustment whereReason($value)
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
        return $this->belongsTo(\Ignite\Core\Entities\User::class, 'user');
    }

}
