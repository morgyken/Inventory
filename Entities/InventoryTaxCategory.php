<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryTaxCategory
 *
 * @property int $id
 * @property string $name
 * @property float $rate
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $rates
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryTaxCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryTaxCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryTaxCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryTaxCategory whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryTaxCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryTaxCategory extends Model {

    protected $fillable = [];
    public $table = 'inventory_tax_categories';

    public function getRatesAttribute() {
        return ($this->rate) . '%';
    }

}
