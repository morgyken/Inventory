<?php

namespace Ignite\Inventory\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryBatchProductSales
 *
 * @property integer $id
 * @property string $receipt
 * @property string $payment_mode
 * @property boolean $paid
 * @property integer $user
 * @property integer $insurance
 * @property integer $customer
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryDispensing[] $goodies
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Inventory\Entities\InventoryPayments $amountpaid
 * @property-read \Ignite\Inventory\Entities\Customer $customers
 * @property-read \Ignite\Inventory\Entities\InventoryInsuranceDetails $insuranceses
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereReceipt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales wherePaymentMode($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales wherePaid($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereInsurance($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereCustomer($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryBatchProductSales whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryBatchProductSales extends Model {

    protected $fillable = [];
    public $table = 'inventory_batch_sales';

    public function goodies() {
        return $this->hasMany(InventoryDispensing::class, 'batch');
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

    public function amountpaid() {
        return $this->hasOne(InventoryPayments::class, 'receipt', 'receipt');
    }

    public function customers() {
        return $this->belongsTo(Customer::class, 'customer');
    }

    public function patient() {
        return $this->belongsTo(\Ignite\Reception\Entities\Patients::class, 'patient');
    }

    public function insuranceses() {
        return $this->belongsTo(InventoryInsuranceDetails::class, 'insurance');
    }

    public function getAmountAttribute() {
        $amount = 0;
        foreach ($this->goodies as $d) {
            $total = $d->quantity * $d->price;
            $amount+=$total;
        }
        return $amount;
    }

}
