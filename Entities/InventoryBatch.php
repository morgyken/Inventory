<?php

namespace Ignite\Inventory\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryBatch
 *
 * @property int $id
 * @property int|null $supplier
 * @property int $amount
 * @property int $user
 * @property int|null $store
 * @property int|null $order
 * @property int|null $in_order
 * @property int $payment_status
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryPurchaseOrders|null $lpo
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryBatchPurchases[] $products
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $suppliers
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereInOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatch whereUser($value)
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
