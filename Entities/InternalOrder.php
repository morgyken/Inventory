<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InternalOrder
 *
 * @property int $id
 * @property int $author
 * @property int $dispatching_store
 * @property int $requesting_store
 * @property string|null $deliver_date
 * @property int $status
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InternalOrderDetails[] $details
 * @property-read \Ignite\Inventory\Entities\Store $disp_store
 * @property-read mixed $nice_status
 * @property-read \Ignite\Inventory\Entities\Store $rq_store
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrder whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrder whereDeliverDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrder whereDispatchingStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrder whereRequestingStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InternalOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InternalOrder extends Model
{

    protected $fillable = [];
    public $table = 'inventory_internal_orders';

    public function users()
    {
        return $this->belongsTo(\Ignite\Users\Entities\User::class, 'author');
    }

    public function disp_store()
    {
        return $this->belongsTo(Store::class, 'dispatching_store');
    }

    public function rq_store()
    {
        return $this->belongsTo(Store::class, 'requesting_store');
    }

    public function details()
    {
        return $this->hasMany(InternalOrderDetails::class, 'internal_order');
    }

    public function getNiceStatusAttribute()
    {
        switch ($this->status) {
            case 0:
                return 'Submitted';
            default:
                return 'Pending';
        }
    }
}
