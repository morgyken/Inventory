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
    protected $table = 'inventory_internal_order_details';

//    protected $appends = ['dispatched'];

    public function product()
    {
        return $this->belongsTo(InventoryProducts::class, 'item');
    }

    public function dispatch()
    {
        return $this->hasMany(InternalOrderDispatch::class, 'item_id');
    }

    public function getDispatchedAttribute(): int
    {
        return $this->dispatch->sum('qty_dispatched');
    }

    public function getPendingAttribute(): int
    {
        return $this->quantity - $this->dispatched;
    }
}
