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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Inventory\Entities\InventoryPurchaseOrderDetails
 *
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read mixed $total
 * @mixin \Eloquent
 */
class InventoryPurchaseOrderDetails extends Model {

    use SoftDeletes;

    protected $fillable = [];
    public $table = 'inventory_purchase_order_details';

    public function products() {
        return $this->hasOne(InventoryProducts::class, 'id', 'product');
    }

    public function getTotalAttribute() {
        return $this->quantity * $this->price;
    }

}
