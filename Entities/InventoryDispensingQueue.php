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
 * Ignite\Inventory\Entities\InventoryDispensingQueue
 *
 * @mixin \Eloquent
 */
class InventoryDispensingQueue extends Model {

    protected $fillable = [];
    public $table = 'inventory_dispensing_queues';

}
