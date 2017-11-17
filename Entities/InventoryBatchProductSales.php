<?php

namespace Ignite\Inventory\Entities;

use Ignite\Finance\Entities\EvaluationPayments;
use Ignite\Finance\Entities\RemovedBills;
use Ignite\Reception\Entities\PatientInsurance;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Ignite\Reception\Entities\Patients;

/**
 * Ignite\Inventory\Entities\InventoryBatchProductSales
 *
 * @property int $id
 * @property string $receipt
 * @property string|null $payment_mode
 * @property int $paid
 * @property int $user
 * @property int|null $insurance
 * @property int|null $customer
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $patient
 * @property int|null $visit
 * @property int $shop
 * @property-read \Ignite\Inventory\Entities\InventoryPayments $amountpaid
 * @property-read \Ignite\Inventory\Entities\Customer|null $customers
 * @property-read mixed $amount
 * @property-read mixed $desc
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryDispensing[] $goodies
 * @property-read \Ignite\Reception\Entities\PatientInsurance|null $insuranceses
 * @property-read \Ignite\Reception\Entities\Patients|null $patients
 * @property-read \Ignite\Finance\Entities\EvaluationPayments $payment
 * @property-read \Ignite\Finance\Entities\RemovedBills $removed_bills
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales wherePatient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales wherePaymentMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereShop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereVisit($value)
 * @mixin \Eloquent
 */
class InventoryBatchProductSales extends Model
{

    protected $fillable = [];
    public $table = 'inventory_batch_sales';

    public function goodies()
    {
        return $this->hasMany(InventoryDispensing::class, 'batch');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function payment()
    {
        return $this->hasOne(EvaluationPayments::class, 'sale');
    }

    public function amountpaid()
    {
        return $this->hasOne(InventoryPayments::class, 'receipt', 'receipt');
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class, 'customer');
    }

    public function patients()
    {
        return $this->belongsTo(Patients::class, 'patient');
    }

    public function insuranceses()
    {
        return $this->belongsTo(PatientInsurance::class, 'insurance');
    }

    public function getAmountAttribute()
    {
        return ceil($this->goodies->sum('total'));
    }

    public function removed_bills()
    {
        return $this->hasOne(RemovedBills::class, 'sale');
    }

    public function getDescAttribute()
    {
        return ($this->shop ? 'SHOP' : 'PHARMACY') . $this->created_at;
    }
}
