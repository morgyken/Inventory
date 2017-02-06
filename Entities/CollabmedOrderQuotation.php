<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryPurchaseOrders
 *
 * @property integer $id
 * @property integer $order
 * @property string $client
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
