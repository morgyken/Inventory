<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\Store
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int|null $clinic
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $desc
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Store whereClinic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Store whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Store whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\Store whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Store extends Model
{

    protected $guarded = [];
    public $table = 'inventory_stores';

    public function getDescAttribute()
    {
        return $this->name . ' - ' . $this->description;
    }


    /*
     * Determines the parent store of a store
     */
    public function parentStore()
    {
        return $this->belongsTo(Store::class, 'parent_store_id');
    }
}
