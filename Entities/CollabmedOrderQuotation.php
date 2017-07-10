<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\CollabmedOrderQuotation
 *
 * @property int $id
 * @property int $supplier
 * @property int $order
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails[] $details
 * @property-read mixed $totals
 * @property-read \Ignite\Inventory\Entities\OrderToCollabmed $orders
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $suppliers
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotation whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotation whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CollabmedOrderQuotation extends Model {

    protected $fillable = [];
    public $table = 'collabmed_order_quotations';

    public function orders() {
        return $this->belongsTo(OrderToCollabmed::class, 'order');
    }

    public function suppliers() {
        return $this->belongsTo(InventorySupplier::class, 'supplier');
    }

    public function details() {
        return $this->hasMany(CollabmedOrderQuotationDetails::class, 'quotation');
    }

    public function getTotalsAttribute() {
        $total = 0;
        foreach ($this->details as $d) {
            $amount = $d->units_required * $d->unit_price;
            $total+=amount;
        }
        return number_format($total, 2);
    }

}
