<?php

namespace Ignite\Inventory\Entities;

use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryBatchProductSales
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Ignite\Inventory\Entities\InventoryDispensing[] $goodies
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read \Ignite\Inventory\Entities\InventoryPayments $amountpaid
 * @property-read \Ignite\Inventory\Entities\Customer $customers
 * @property-read \Ignite\Inventory\Entities\InventoryInsuranceDetails $insuranceses
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

    public function insuranceses() {
        return $this->belongsTo(InventoryInsuranceDetails::class, 'insurance');
    }

}
