<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Inventory\Entities\InventoryPurchaseOrders
 *
 * @property int $id
 * @property int $supplier
 * @property int $payment_terms
 * @property string $payment_mode
 * @property string|null $deliver_date
 * @property int $status
 * @property int $user
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails[] $details
 * @property-read mixed $status_label
 * @property-read mixed $totals
 * @property-read \Ignite\Inventory\Entities\InventoryPaymentTerms $payment_options
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $suppliers
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders approved()
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereDeliverDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders wherePaymentMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders wherePaymentTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders withoutTrashed()
 * @mixin \Eloquent
 */
class InventoryPurchaseOrders extends Model {

    use SoftDeletes;

    protected $fillable = [];
    public $table = 'inventory_purchase_orders';

    public function details() {
        return $this->hasMany(InventoryPurchaseOrderDetails::class, 'order');
    }

    public function suppliers() {
        return $this->hasOne(InventorySupplier::class, 'id', 'supplier');
    }

    public function payment_options() {
        return $this->hasOne(InventoryPaymentTerms::class, 'id', 'payment_terms');
    }

    public function getTotalsAttribute() {
        return number_format($this->details->sum('total'), 2);
    }

    public function getStatusLabelAttribute() {
        return config('inventory.lpo_status.' . $this->status);
    }

    public function scopeApproved($query) {
        return $query->where('status', 1);
    }

}
