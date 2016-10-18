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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryProducts[] $products
 * @mixin \Eloquent
 */
class InventoryCategories extends Model {

    protected $fillable = [];
    public $table = 'inventory_categories';

    public function products() {
        return $this->hasMany(InventoryProducts::class, 'category');
    }

}
