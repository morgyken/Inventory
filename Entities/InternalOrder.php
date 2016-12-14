<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InternalOrder
 *
 * @property integer $id
 * @property integer $author
 * @property integer $dispatching_store
 * @property integer $requesting_store
 * @property string $deliver_date
 * @property boolean $status
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Inventory\Entities\Store $disp_store
 * @property-read \Ignite\Inventory\Entities\Store $rq_store
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InternalOrderDetails[] $details
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereDispatchingStore($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereRequestingStore($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereDeliverDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InternalOrder extends Model {

    protected $fillable = [];
    public $table = 'inventory_internal_orders';

    public function users() {
        return $this->belongsTo(\Ignite\Users\Entities\User::class, 'author');
    }

    public function disp_store() {
        return $this->hasOne(Store::class, 'id', 'dispatching_store');
    }

    public function rq_store() {
        return $this->hasOne(Store::class, 'id', 'requesting_store');
    }

    public function details() {
        return $this->hasMany(InternalOrderDetails::class, 'internal_order');
    }

}
