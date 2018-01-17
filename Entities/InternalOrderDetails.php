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
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InternalOrderDispatch[] $dispatch
 * @property-read mixed $dispatched
 * @property-read mixed $pending
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $product
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereInternalOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InternalOrderDetails extends Model
{
    protected $guarded = [];

    protected $table = 'inventory_store_order_details';

    public function product()
    {
        return $this->belongsTo(InventoryProducts::class, 'product_id');
    }

    public function dispatch()
    {
        return $this->hasMany(InternalOrderDispatch::class, 'order_detail_id');
    }

    public function received()
    {
        return $this->hasMany(InternalReceivedOrders::class, 'order_detail_id');
    }

    public function getDispatchedAttribute(): int
    {
        return $this->dispatch->sum('dispatched');
    }

    public function getPendingAttribute(): int
    {
        return $this->quantity - $this->dispatched;
    }

    public function getAvailableAttribute($query)
    {
        return $this->dispatched - ($this->accepted + $this->rejected);
    }

    public function getAcceptedAttribute() : int
    {
        return $this->received->sum('received');
    }

    public function getRejectedAttribute() : int
    {
        return $this->received->sum('rejected');
    }
}
