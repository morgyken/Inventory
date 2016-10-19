<?php

namespace Ignite\Inventory\Entities;

use Ignite\Settings\Entities\Insurance;
use Ignite\Settings\Entities\Schemes;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryInsuranceDetails
 *
 * @property-read \Ignite\Inventory\Entities\Customer $clients
 * @property-read \Ignite\Settings\Entities\Insurance $companies
 * @property-read \Ignite\Settings\Entities\Schemes $schemes
 * @mixin \Eloquent
 */
class InventoryInsuranceDetails extends Model {

    protected $fillable = [];

    public function clients() {
        return $this->belongsTo(Customer::class, 'customer', 'id');
    }

    public function companies() {
        return $this->belongsTo(Insurance::class, 'insurance_company', 'id');
    }

    public function schemes() {
        return $this->belongsTo(Schemes::class, 'credit_scheme', 'id');
    }

}
