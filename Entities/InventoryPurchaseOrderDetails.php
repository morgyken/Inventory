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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Inventory\Entities\InventoryPurchaseOrderDetails
 *
 * @property integer $id
 * @property integer $order
 * @property integer $product
 * @property integer $quantity
 * @property float $price
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @property-read mixed $total
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereProduct($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryPurchaseOrderDetails extends Model {

    use SoftDeletes;

    protected $fillable = [];
    public $table = 'inventory_purchase_order_details';

    public function products() {
        return $this->hasOne(InventoryProducts::class, 'id', 'product');
    }

    public function getTotalAttribute() {
        return $this->quantity * $this->price;
    }

}
