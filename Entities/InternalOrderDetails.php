<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InternalOrderDetails
 *
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $items
 * @mixin \Eloquent
 */
class InternalOrderDetails extends Model {

    protected $fillable = [];
    protected $table = 'internal_order_details';

    public function items() {
        return $this->belongsTo(InventoryProducts::class, 'item');
    }

}
