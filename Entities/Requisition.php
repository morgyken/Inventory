<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\Customer
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_of_birth
 * @property string $email
 * @property string $phone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Customer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Customer whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Customer whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Customer whereDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Customer whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Customer wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Customer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Requisition extends Model {

    protected $fillable = ['user', 'reason'];

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
