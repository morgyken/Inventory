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
 * @property integer $status
 * @property integer $quantity
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereDispatchingStore($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereRequestingStore($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereDeliverDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InternalOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InternalOrder extends Model
{

    protected $fillable = [];
    public $table = 'inventory_internal_orders';
}
