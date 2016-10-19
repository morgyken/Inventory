<?php

namespace Ignite\Inventory\Entities;

use Ignite\Settings\Entities\Schemes;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryPayments
 *
 * @property integer $id
 * @property string $receipt
 * @property integer $scheme
 * @property mixed $InsuranceAmount
 * @property mixed $CashAmount
 * @property mixed $MpesaReference
 * @property mixed $MpesaAmount
 * @property mixed $MpesaNumber
 * @property mixed $paybil
 * @property mixed $account
 * @property mixed $ChequeName
 * @property mixed $ChequeAmount
 * @property mixed $ChequeNumber
 * @property mixed $ChequeDate
 * @property mixed $ChequeBank
 * @property mixed $ChequeBankBranch
 * @property mixed $CardType
 * @property mixed $CardName
 * @property mixed $CardNumber
 * @property mixed $CardExpiry
 * @property mixed $CardSecurity
 * @property mixed $CardAmount
 * @property string $description
 * @property integer $user
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read mixed $total
 * @property-read \Ignite\Users\Entities\User $users
 * @property-read mixed $modes
 * @property-read \Ignite\Settings\Entities\Schemes $schemes
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereReceipt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereScheme($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereInsuranceAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCashAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereMpesaReference($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereMpesaAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereMpesaNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments wherePaybil($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereAccount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeBank($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeBankBranch($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardType($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardName($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardExpiry($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardSecurity($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereUser($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Ignite\Inventory\Entities\InventoryPayments whereUpdatedAt($value)
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
