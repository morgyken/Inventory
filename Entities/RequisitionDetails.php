<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\RequisitionDetails
 *
 * @property integer $id
 * @property integer $requisition
 * @property integer $item
 * @property integer $quantity
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\Requisition $requisitions
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $items
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereRequisition($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereItem($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereQuantity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\RequisitionDetails whereUpdatedAt($value)
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
