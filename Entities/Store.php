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
    public $table = 'inventory_stores';

    protected $fillable = [
        'name', 'description', 'clinic', 'parent_store_id', 'main_store', 'delivery_store'
    ];

    /*
     * Relationship between a store and a clinic/department
     */
    public function department()
    {
        return $this->belongsTo(StoreDepartment::class, 'clinic');
    }

    /*
     * Determines the parent store of a store
     */
    public function parentStore()
    {
        return $this->belongsTo(Store::class, 'parent_store_id');
    }

    /*
     * Relationship between orders made by a store and the store
     */
    public function orders()
    {
        return $this->hasMany(InternalOrder::class, 'requesting_store');
    }

    /*
     * Relationship between orders received by a store and the store
     */
    public function received()
    {
        return $this->hasMany(InternalOrder::class, 'dispatching_store');
    }

    /*
     * Relationship between a store and all its products
     */
    public function products()
    {
        return $this->belongsToMany(InventoryProducts::class, 'inventory_store_products', 'store_id', 'product_id')
                    ->withPivot('quantity', 'selling_price', 'insurance_price')->withTimestamps();
    }
}
