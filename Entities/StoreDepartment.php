<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class StoreDepartment extends Model
{
    protected $table = "inventory_store_departments";

    protected $guarded = [];

    /*
     * Accessor for the name attribute
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    /*
     * Relationship between a store and a department
     */
    public function stores()
    {
        return $this->hasMany(Store::class, 'clinic');
    }
}
