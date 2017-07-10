<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\OrderToCollabmed
 *
 * @property int $id
 * @property int $order
 * @property string $client
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryPurchaseOrders $orders
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\OrderToCollabmed whereClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\OrderToCollabmed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\OrderToCollabmed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\OrderToCollabmed whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\OrderToCollabmed whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\OrderToCollabmed whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderToCollabmed extends Model {

    protected $fillable = [];
    public $table = 'inventory_orders_collabmed';

    public function orders() {
        return $this->belongsTo(InventoryPurchaseOrders::class, 'order');
    }

}
