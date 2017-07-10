<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryProductPrice
 *
 * @property int $id
 * @property int $product
 * @property int|null $batch
 * @property float|null $price
 * @property float|null $selling
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $cash_price
 * @property-read mixed $credit_price
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereBatch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereSelling($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryProductPrice extends Model {

    protected $guarded = [];
    public $table = 'inventory_product_price';
    public $appends = ['cash_price', 'credit_price'];

    public function getSellingAttribute($value) {
        return ceil($value);
    }

    public function getPriceAttribute($value) {
        return ceil($value);
    }

    public function getCashPriceAttribute() {
        if (empty($this->products->categories)) {
            return $this->selling;
        }
        return ceil(($this->products->categories->cash_markup + 100) / 100 * $this->price);
    }

    public function getCreditPriceAttribute() {
        if (empty($this->products->categories)) {
            return $this->selling;
        }
        return ceil(($this->products->categories->credit_markup + 100) / 100 * $this->price);
    }

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
