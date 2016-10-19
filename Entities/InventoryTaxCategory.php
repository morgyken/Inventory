<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryTaxCategory
 *
 * @property-read mixed $rates
 * @mixin \Eloquent
 */
class InventoryTaxCategory extends Model {

    protected $fillable = [];
    public $table = 'inventory_tax_categories';

    public function getRatesAttribute() {
        return ($this->rate) . '%';
    }

}
