<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Inventory\Entities\InventoryPurchaseOrderDetails
 *
 * @property int $id
 * @property int $order
 * @property int $product
 * @property int $quantity
 * @property float $price
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $total
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails withoutTrashed()
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
