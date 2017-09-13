<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryProducts
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $category
 * @property int $unit
 * @property int|null $tax_category
 * @property int|null $reorder_level
 * @property string|null $strength
 * @property string|null $label_type
 * @property string|null $formulation
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $consumable
 * @property-read \Ignite\Inventory\Entities\InventoryCategories $categories
 * @property-read \Ignite\Inventory\Entities\InventoryProductDiscount $discounts
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryProductExclusion[] $exclusions
 * @property-read mixed $count_active_batch
 * @property-read mixed $product_code
 * @property-read mixed $selling_p
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryProductPrice[] $prices
 * @property-read \Ignite\Inventory\Entities\InventoryStock $stocks
 * @property-read \Ignite\Inventory\Entities\InventoryTaxCategory|null $taxgroups
 * @property-read \Ignite\Inventory\Entities\InventoryUnits $units
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereConsumable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereFormulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereLabelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereReorderLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereStrength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereTaxCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryProducts whereUpdatedAt($value)
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

    public function getSellingPAttribute() {
        $price = 0;
        foreach ($this->prices as $p) {
            if ($price > $p->price) {
                $p = $price;
            }
        }
        return $price;
    }

}
