<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryInvoice
 *
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $creditors
 * @property-read \Ignite\Finance\Entities\FinanceGlAccounts $gls
 * @mixin \Eloquent
 */
class InventoryInvoice extends Model {

    protected $fillable = [];
    public $table = 'finance_invoices';

    public function creditors() {
        return $this->belongsTo(InventorySupplier::class, 'creditor');
    }

    public function gls() {
        return $this->belongsTo(\Ignite\Finance\Entities\FinanceGlAccounts::class, 'gl_account');
    }

}
