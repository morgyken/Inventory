<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InternalOrderDetails
 *
 * @property int $id
 * @property int $internal_order
 * @property int $item
 * @property int $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $items
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereInternalOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InternalOrderDetails extends Model {

    protected $fillable = [];
    protected $table = 'inventory_internal_order_details';

    public function items() {
        return $this->belongsTo(InventoryProducts::class, 'item');
    }

}
