<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryCategories
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent
 * @property float $cash_markup
 * @property float $credit_markup
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryProducts[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryCategories whereCashMarkup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryCategories whereCreditMarkup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryCategories whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryCategories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryCategories whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryCategories whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryCategories extends Model {

    protected $fillable = [];
    public $table = 'inventory_categories';

    public function products() {
        return $this->hasMany(InventoryProducts::class, 'category');
    }

}
