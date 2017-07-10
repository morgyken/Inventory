<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryBatchPurchases
 *
 * @property int $id
 * @property int $batch
 * @property int $product
 * @property int $quantity
 * @property int|null $qty_sold
 * @property int $active
 * @property int $bonus
 * @property float $discount
 * @property float $tax
 * @property float $unit_cost
 * @property string|null $expiry_date
 * @property int $package_size
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $creitors
 * @property-read mixed $remaining
 * @property-read mixed $total
 * @property-read \Ignite\Inventory\Entities\InventoryPurchaseOrders $lpo
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $suppliers
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases wherePackageSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereQtySold($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchPurchases whereUpdatedAt($value)
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

    public function creitors() {
        return $this->belongsTo(InventorySupplier::class, 'product', 'id');
    }

    public function suppliers() {
        return $this->hasOne(InventorySupplier::class, 'id', 'supplier');
    }

    public function getTotalAttribute() {
        $total = $this->unit_cost * $this->quantity * $this->package_size;
        $taxable = ($this->tax / 100) * $total;
        return ($total + $taxable) - ($total * $this->discount / 100);
    }

    public function getRemainingAttribute() {
        $r = ($this->package_size * $this->quantity) - $this->qty_sold;
        return $r + $this->bonus;
    }

}
