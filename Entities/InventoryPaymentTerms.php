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
 * Ignite\Inventory\Entities\InventoryPaymentTerms
 *
 * @mixin \Eloquent
 */
class InventoryPaymentTerms extends Model {

    protected $fillable = [];
    public $table = 'inventory_payment_terms';

}
