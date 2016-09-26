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
 * @property integer $id
 * @property string $number
 * @property integer $creditor
 * @property integer $gl_account
 * @property integer $batch
 * @property float $amount
 * @property string $date
 * @property string $due_date
 * @property string $description
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Ignite\Inventory\Entities\InventorySupplier $creditors
 * @property-read \Ignite\Finance\Entities\FinanceGlAccounts $gls
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereCreditor($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereGlAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereBatch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereDueDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryInvoice whereUpdatedAt($value)
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
