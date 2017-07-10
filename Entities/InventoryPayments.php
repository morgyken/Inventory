<?php

namespace Ignite\Inventory\Entities;

use Ignite\Settings\Entities\Schemes;
use Ignite\Users\Entities\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Ignite\Inventory\Entities\InventoryPayments
 *
 * @property int $id
 * @property string $receipt
 * @property int|null $scheme
 * @property mixed|null $InsuranceAmount
 * @property mixed|null $CashAmount
 * @property mixed|null $MpesaReference
 * @property mixed|null $MpesaAmount
 * @property mixed|null $MpesaNumber
 * @property mixed|null $paybil
 * @property mixed|null $account
 * @property mixed|null $ChequeName
 * @property mixed|null $ChequeAmount
 * @property mixed|null $ChequeNumber
 * @property mixed|null $ChequeDate
 * @property mixed|null $ChequeBank
 * @property mixed|null $ChequeBankBranch
 * @property mixed|null $CardType
 * @property mixed|null $CardName
 * @property mixed|null $CardNumber
 * @property mixed|null $CardExpiry
 * @property mixed|null $CardSecurity
 * @property mixed|null $CardAmount
 * @property string|null $description
 * @property int $user
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $modes
 * @property-read mixed $total
 * @property-read \Ignite\Settings\Entities\Schemes|null $schemes
 * @property-read \Ignite\Users\Entities\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardSecurity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCardType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCashAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeBankBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereChequeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereInsuranceAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereMpesaAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereMpesaNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereMpesaReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments wherePaybil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereReceipt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereScheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Ignite\Inventory\Entities\InventoryPayments whereUser($value)
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
