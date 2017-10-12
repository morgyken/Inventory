<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryDispensing
 *
 * @property int $id
 * @property int $batch
 * @property int $product
 * @property float $price
 * @property float $discount
 * @property int $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $customers
 * @property-read mixed $original_price
 * @property-read mixed $total
 * @property-read mixed $unit_cost
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read \Ignite\Inventory\Entities\InventoryBatchProductSales $sale
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryDispensing whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryDispensing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryDispensing whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryDispensing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryDispensing wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryDispensing whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryDispensing whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryDispensing whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryDispensing extends Model
{

    protected $fillable = [];
    public $table = 'inventory_dispensing';

    public function sale()
    {
        return $this->belongsTo(InventoryBatchProductSales::class, 'batch');
    }

    public function getOriginalPriceAttribute()
    {
        return $this->product * $this->price * $this->quantity;
    }

    public function getTotalAttribute()
    {
        return $this->unit_cost * $this->quantity;
    }

    public function getUnitCostAttribute()
    {
        return empty($this->discount) ? $this->price : $this->price - ($this->discount * $this->price / 100);
    }

    public function products()
    {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

    public function customers()
    {
        return $this->belongsTo(InventoryProducts::class, 'customer');
    }

}
