<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryDispensing
 *
 * @property-read mixed $original_price
 * @property-read mixed $total
 * @property-read mixed $unit_cost
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $customers
 * @mixin \Eloquent
 */
class InventoryDispensing extends Model {

    protected $fillable = [];
    public $table = 'inventory_dispensing';

    public function getOriginalPriceAttribute() {
        return $this->product * $this->price * $this->quantity;
    }

    public function getTotalAttribute() {
        return $this->unit_cost * $this->quantity;
    }

    public function getUnitCostAttribute() {
        return empty($this->discount) ? $this->price : $this->price - ($this->discount * $this->price / 100);
    }

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

    public function customers() {
        return $this->belongsTo(InventoryProducts::class, 'customer');
    }

}
