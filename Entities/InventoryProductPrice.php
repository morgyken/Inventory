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
 * @property-read mixed $selling
 * @property-read mixed $price
 * @property-read mixed $cash_price
 * @property-read mixed $credit_price
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
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
