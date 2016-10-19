<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryProducts
 *
 * @property-read \Ignite\Inventory\Entities\InventoryCategories $categories
 * @property-read \Ignite\Inventory\Entities\InventoryUnits $units
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryProductPrice[] $prices
 * @property-read \Ignite\Inventory\Entities\InventoryTaxCategory $taxgroups
 * @property-read \Ignite\Inventory\Entities\InventoryProductDiscount $discounts
 * @property-read mixed $product_code
 * @property-read \Ignite\Inventory\Entities\InventoryStock $stocks
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryProductExclusion[] $exclusions
 * @property-read mixed $count_active_batch
 * @mixin \Eloquent
 */
class InventoryProducts extends Model {

    protected $fillable = ['name', 'description', 'category', 'unit', 'tax_category', 'strength', 'label_type', 'formulation'];
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

    public function taxgroups() {
        return $this->belongsTo(InventoryTaxCategory::class, 'tax_category');
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

    public function getCountActiveBatchAttribute() {
        $active = InventoryBatchPurchases::where('product', '=', $this->id)->count();
        return $active;
    }

}
