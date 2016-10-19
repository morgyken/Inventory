<?php

namespace Ignite\Inventory\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryBatch
 *
 * @property-read \Ignite\Inventory\Entities\InventoryPurchaseOrders $lpo
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryBatchPurchases[] $products
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $suppliers
 * @property-read \Ignite\Users\Entities\User $users
 * @mixin \Eloquent
 */
class InventoryBatch extends Model {

    protected $fillable = [];
    public $table = 'inventory_batches';

    public function lpo() {
        return $this->belongsTo(InventoryPurchaseOrders::class, 'order', 'id');
    }

    public function products() {
        return $this->hasMany(InventoryBatchPurchases::class, 'batch');
    }

    public function suppliers() {
        return $this->hasOne(InventorySupplier::class, 'id', 'supplier');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

}
