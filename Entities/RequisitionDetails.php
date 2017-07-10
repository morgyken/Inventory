<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\RequisitionDetails
 *
 * @property int $id
 * @property int $requisition
 * @property int $item
 * @property int $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $items
 * @property-read \Ignite\Inventory\Entities\Requisition $requisitions
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereRequisition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RequisitionDetails extends Model {

    public $table = 'inventory_requisition_details';

    public function requisitions() {
        return $this->belongsTo(Requisition::class, 'requisition');
    }

    public function items() {
        return $this->belongsTo(InventoryProducts::class, 'item');
    }

}
