<?php

namespace Ignite\Inventory\Entities;

use Ignite\Finance\Entities\FinanceGlAccounts;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryInvoice
 *
 * @property int $id
 * @property string $number
 * @property int $creditor
 * @property int|null $gl_account
 * @property int|null $grn
 * @property float $amount
 * @property string $date
 * @property string $due_date
 * @property string|null $description
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $creditors
 * @property-read \Ignite\Finance\Entities\FinanceGlAccounts|null $gls
 * @property-read \Ignite\Inventory\Entities\InventoryBatch|null $grns
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereGlAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereGrn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryInvoice extends Model {

    protected $fillable = [];
    public $table = 'inventory_finance_invoices';

    public function creditors() {
        return $this->belongsTo(InventorySupplier::class, 'creditor');
    }

    public function gls() {
        return $this->belongsTo(FinanceGlAccounts::class, 'gl_account');
    }

    public function grns() {
        return $this->belongsTo(InventoryBatch::class, 'grn');
    }

}
