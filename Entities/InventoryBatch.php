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
 * Ignite\Inventory\Entities\InventoryBatch
 *
 * @property integer $id
 * @property integer $supplier
 * @property integer $amount
 * @property integer $user
 * @property integer $store
 * @property integer $order
 * @property integer $in_order
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryPurchaseOrders $lpo
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryBatchPurchases[] $products
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $suppliers
 * @property-read \Ignite\Core\Entities\User $users
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereSupplier($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereStore($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereInOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatch whereUpdatedAt($value)
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
