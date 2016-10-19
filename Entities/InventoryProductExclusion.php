<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryProductExclusion
 *
 * @mixin \Eloquent
 */
class InventoryProductExclusion extends Model {

    protected $fillable = ['product', 'scheme'];

}
