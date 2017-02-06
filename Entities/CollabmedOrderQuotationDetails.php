<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryPurchaseOrders
 *
 * @property integer $id
 * 
 */
class CollabmedOrderQuotationDetails extends Model {

    protected $fillable = [];
    public $table = 'collabmed_order_quotation_details';

    public function quatations() {
        return $this->belongsTo(CollabmedOrderQuotation::class, 'quatation');
    }

    public function items() {
        return $this->belongsTo(InventoryProducts::class, 'item');
    }

}
