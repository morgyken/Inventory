<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventorySupplier
 *
 * @mixin \Eloquent
 */
class InventorySupplier extends Model {

    protected $fillable = [];
    public $table = 'inventory_suppliers';

}
