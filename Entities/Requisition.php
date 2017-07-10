<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\Requisition
 *
 * @property int $id
 * @property int $user
 * @property string|null $reason
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\RequisitionDetails[] $details
 * @property-read mixed $item_count
 * @property-read \Illuminate\Foundation\Auth\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Requisition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Requisition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Requisition whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Requisition whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Requisition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Requisition whereUser($value)
 * @mixin \Eloquent
 */
class Requisition extends Model {

    protected $fillable = ['user', 'reason'];
    public $table = 'inventory_requisition';

    public function users() {
        return $this->belongsTo(\Illuminate\Foundation\Auth\User::class, 'user');
    }

    public function details() {
        return $this->hasMany(RequisitionDetails::class, 'requisition');
    }

    public function getItemCountAttribute() {
        return $this->details()->count('item');
    }

}
