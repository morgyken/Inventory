<?php

namespace Ignite\Inventory\Entities;

use Ignite\Settings\Entities\Insurance;
use Ignite\Settings\Entities\Schemes;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryInsuranceDetails
 *
 * @property integer $id
 * @property integer $customer
 * @property integer $insurance_company
 * @property integer $credit_scheme
 * @property string $policy_no
 * @property string $principal
 * @property string $date_of_birth
 * @property string $relation
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\Customer $clients
 * @property-read \Ignite\Settings\Entities\Insurance $companies
 * @property-read \Ignite\Settings\Entities\Schemes $schemes
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails whereCustomer($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails whereInsuranceCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails whereCreditScheme($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails wherePolicyNo($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails wherePrincipal($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails whereDateOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails whereRelation($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInsuranceDetails whereUpdatedAt($value)
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
