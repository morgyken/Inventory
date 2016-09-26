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
 * Ignite\Inventory\Entities\InventoryCategories
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent
 * @property float $cash_markup
 * @property float $credit_markup
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryProducts[] $products
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryCategories whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryCategories whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryCategories whereParent($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryCategories whereCashMarkup($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryCategories whereCreditMarkup($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryCategories whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryCategories whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryCategories extends Model {

    protected $fillable = [];
    public $table = 'inventory_categories';

    public function products() {
        return $this->hasMany(InventoryProducts::class, 'category');
    }

}
