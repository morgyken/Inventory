<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryPurchaseOrders
 *
 * @property integer $id
 * @property integer $order
 * @property string $client
 */
class OrderToCollabmed extends Model {

    protected $fillable = [];
    public $table = 'inventory_orders_collabmed';

    public function orders() {
        return $this->belongsTo(InventoryPurchaseOrders::class, 'order');
    }

}
