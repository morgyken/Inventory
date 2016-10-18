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

use Ignite\Settings\Entities\Schemes;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryPayments
 *
 * @property-read mixed $total
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read mixed $modes
 * @property-read \Ignite\Settings\Entities\Schemes $schemes
 * @mixin \Eloquent
 */
class InventoryPayments extends Model {

    protected $fillable = [];

    public function getTotalAttribute() {
        return $this->CardAmount + $this->CashAmount + $this->ChequeAmount + $this->MpesaAmount;
    }

    public function users() {
        return $this->belongsTo(User::class, 'user');
    }

    public function getModesAttribute() {
        $text = [];
        if (!empty($this->CashAmount))
            $text[] = "Cash - " . $this->CashAmount;
        if (!empty($this->MpesaAmount))
            $text[] = 'MPESA - ' . $this->MpesaAmount;
        if (!empty($this->CardAmount))
            $text[] = $this->CardType . ' - ' . $this->CardAmount;
        if (!empty($this->ChequeAmount))
            $text[] = 'Cheque - ' . $this->ChequeAmount;
        if (!empty($this->InsuranceAmount))
            $text[] = 'Insurance - ' . $this->InsuranceAmount;
        return $text;
    }

    public function schemes() {
        return $this->belongsTo(Schemes::class, 'scheme');
    }

}
