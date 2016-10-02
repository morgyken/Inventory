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
 * Ignite\Inventory\Entities\InventoryProducts
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $category
 * @property integer $unit
 * @property integer $tax_category
 * @property string $strength
 * @property string $label_type
 * @property string $formulation
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryCategories $categories
 * @property-read \Ignite\Inventory\Entities\InventoryUnits $units
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryProductPrice[] $prices
 * @property-read \Ignite\Inventory\Entities\InventoryProductDiscount $discounts
 * @property-read mixed $product_code
 * @property-read \Ignite\Inventory\Entities\InventoryStock $stocks
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryProductExclusion[] $exclusions
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereUnit($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereTaxCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereStrength($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereLabelType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereFormulation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProducts whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryProducts extends Model {

    protected $fillable = [];
    public $table = 'inventory_products';

    public function categories() {
        return $this->belongsTo(InventoryCategories::class, 'category', 'id');
    }

    public function units() {
        return $this->belongsTo(InventoryUnits::class, 'unit');
    }

    public function prices() {
        return $this->hasMany(InventoryProductPrice::class, 'product');
    }

    public function discounts() {
        return $this->hasOne(InventoryProductDiscount::class, 'product', 'id');
    }

    public function getProductCodeAttribute() {
        return (1000 + $this->id);
    }

    public function stocks() {
        return $this->hasOne(InventoryStock::class, 'product');
    }

    public function exclusions() {
        return $this->hasMany(InventoryProductExclusion::class, 'product');
    }

}
