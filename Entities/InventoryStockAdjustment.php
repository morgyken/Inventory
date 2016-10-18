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
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read \Ignite\Users\Entities\User $users
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
