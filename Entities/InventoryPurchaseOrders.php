<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Ignite\Inventory\Entities\InventoryPurchaseOrders
 *
 * @property integer $id
 * @property integer $supplier
 * @property integer $payment_terms
 * @property integer $payment_mode
 * @property string $deliver_date
 * @property integer $status
 * @property integer $user
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryPurchaseOrderDetails[] $details
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $suppliers
 * @property-read \Ignite\Inventory\Entities\InventoryPaymentTerms $payment_options
 * @property-read mixed $totals
 * @property-read mixed $status_label
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereSupplier($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders wherePaymentTerms($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders wherePaymentMode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereDeliverDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPurchaseOrders approved()
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
