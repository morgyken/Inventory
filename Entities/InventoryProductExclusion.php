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
 * Ignite\Inventory\Entities\InventoryProductExclusion
 *
 * @property integer $id
 * @property integer $product
 * @property integer $scheme
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductExclusion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductExclusion whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductExclusion whereScheme($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductExclusion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryProductExclusion whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryProductExclusion extends Model {

    protected $fillable = ['product', 'scheme'];

}
