<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\Store
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $clinic
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Store whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Store whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Store whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Store whereClinic($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\Store whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Store extends Model {

    protected $fillable = [];
    public $table = 'inventory_stores';

}
