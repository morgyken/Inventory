<?php

namespace Ignite\Inventory\Entities;

use Ignite\Finance\Entities\FinanceGlAccounts;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryInvoice
 *
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $creditors
 * @property-read \Ignite\Finance\Entities\FinanceGlAccounts $gls
 * @property-read \Ignite\Inventory\Entities\InventoryBatch $grns
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
