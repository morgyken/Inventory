<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InternalOrderDispatch
 *
 * @property int $id
 * @property int $item_id
 * @property int $qty_dispatched
 * @property int|null $qty_accepted
 * @property int|null $qty_rejected
 * @property int|null $batch_id
 * @property string|null $reject_reason
 * @property int $dispatch_user
 * @property int|null $receive_user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereDispatchUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereQtyAccepted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereQtyDispatched($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereQtyRejected($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereReceiveUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereRejectReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrderDispatch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InternalOrderDispatch extends Model
{
    protected $guarded = [];
    protected $table = 'inventory_internal_order_dispatches';
}
