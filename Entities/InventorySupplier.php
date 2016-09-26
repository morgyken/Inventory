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
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $post_code
 * @property string $town
 * @property string $street
 * @property string $building
 * @property string $telephone
 * @property string $mobile
 * @property string $fax
 * @property string $email
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier wherePostCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereTown($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereStreet($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereBuilding($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereTelephone($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventorySupplier whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventorySupplier extends Model {

    protected $fillable = [];
    public $table = 'inventory_suppliers';

}
