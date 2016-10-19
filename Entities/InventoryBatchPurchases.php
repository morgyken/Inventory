<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryBatchPurchases
 *
 * @property-read \Ignite\Inventory\Entities\InventoryPurchaseOrders $lpo
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $creitors
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $suppliers
 * @property-read mixed $total
 * @property-read mixed $remaining
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
