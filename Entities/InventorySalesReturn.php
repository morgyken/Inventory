<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventorySalesReturn
 *
 * @property int $id
 * @property int $product
 * @property string $receipt_no
 * @property int $quantity
 * @property string $reason
 * @property int $stocked
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $products
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventorySalesReturn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventorySalesReturn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventorySalesReturn whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventorySalesReturn whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventorySalesReturn whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventorySalesReturn whereReceiptNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventorySalesReturn whereStocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventorySalesReturn whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventorySalesReturn extends Model {

    protected $fillable = [];
    public $table = 'inventory_sales_returns';

    public function products() {
        return $this->belongsTo(InventoryProducts::class, 'product');
    }

}
