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
 * Ignite\Inventory\Entities\InventoryProductPrice
 *
 * @property integer $id
 * @property integer $product
 * @property integer $batch
 * @property float $price
 * @property float $selling
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $cash_price
 * @property-read mixed $credit_price
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereBatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductPrice wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereSelling($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductPrice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryProductPrice extends Model {

    protected $guarded = [];
    public $table = 'inventory_product_price';
    public $appends = ['cash_price', 'credit_price'];

    public function getSellingAttribute($value) {
        return intval($value);
    }

    public function getPriceAttribute($value) {
        return intval($value);
    }

    public function getCashPriceAttribute() {
        if (empty($this->products->categories)) {
            return $this->selling;
        }
        return intval(($this->products->categories->cash_markup + 100) / 100 * $this->price);
    }

    public function getCreditPriceAttribute() {
        if (empty($this->products->categories)) {
            return $this->selling;
        }
        return intval(($this->products->categories->credit_markup + 100) / 100 * $this->price);
    }

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
