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

}
