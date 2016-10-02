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
 * Ignite\Inventory\Entities\InventoryBatchPurchases
 *
 * @property integer $id
 * @property integer $batch
 * @property integer $product
 * @property integer $quantity
 * @property integer $qty_sold
 * @property boolean $active
 * @property integer $bonus
 * @property float $discount
 * @property float $unit_cost
 * @property string $expiry_date
 * @property integer $package_size
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryPurchaseOrders $lpo
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $creditors
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $suppliers
 * @property-read mixed $total
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereBatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereQtySold($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereBonus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereDiscount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereUnitCost($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereExpiryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases wherePackageSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryBatchPurchases extends Model {

    protected $fillable = [];
    public $table = 'inventory_batch_purchases';

    public function lpo() {
        return $this->belongsTo(InventoryPurchaseOrders::class, 'order', 'id');
    }

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product', 'id');
    }

    public function creditors() {
        return $this->belongsTo(InventorySupplier::class, 'product', 'id');
    }

    public function suppliers() {
        return $this->hasOne(InventorySupplier::class, 'id', 'supplier');
    }

    public function getTotalAttribute() {
        $total = $this->unit_cost * $this->quantity * $this->package_size;
        return $total - ($total * $this->discount / 100);
    }

}
