<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\CollabmedOrderQuotationDetails
 *
 * @property int $id
 * @property int $quotation
 * @property int $item
 * @property int $units_required
 * @property int|null $units_to_supply
 * @property float|null $unit_price
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventoryProducts $items
 * @property-read \Ignite\Inventory\Entities\CollabmedOrderQuotation $quatations
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails whereQuotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails whereUnitsRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails whereUnitsToSupply($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\CollabmedOrderQuotationDetails whereUpdatedAt($value)
 * @mixin \Eloquent
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
