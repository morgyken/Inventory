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
?>
<div class="row">
    <div class="col-md-7">
        <table class="table table-condensed">
            <tr>
                <td></td>
                <td><label class="control-label" for="payment_mode">Payment Mode</label></td>
                <td>
                    <div class="form-group {{ $errors->has('payment_mode') ? ' has-error' : '' }} req">
                        <div>
                            {!! Form::select('payment_mode',mconfig('inventory.options.payment_modes'),null,['class'=>'form-control payment', 'required','id'=>'payment_mode']) !!}
                            {!! $errors->first('payment_mode', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div id="card">
            <div class="element atStart">
                <table class="table" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td></td>
                        <td width="20%">Card Type:</td>
                        <td width="26%">
                            <select name='CardType'>
                                <option value='VISA' selected>VISA
                                <option value='MasterCard'>MasterCard
                            </select>
                        </td>
                        <td width="24%">Exact Names On Card</td>
                        <td width="30%">
                            <input name="CardNames" type="text" value="" />
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Card No:</td>
                        <td><input type='text' name='CardNumber' value='' size=20 maxlength=100></td>
                        <td>Expiry Date:</td>
                        <td><select name='expiry_month'>
                                <option value='01' selected>01
                                <option value='02'>02
                                <option value='03'>03
                                <option value='04'>04
                                <option value='05'>05
                                <option value='06'>06
                                <option value='07'>07
                                <option value='08'>08
                                <option value='09'>09
                                <option value='10'>10
                                <option value='11'>11
                                <option value='12'>12
                            </select>
                            <input type='text' name='expiry_year' value='2016' size=4 maxlength=4/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2">Security Digits at back of card: (Can be 3 or 4 Digits)</td>
                        <td><input type='text' name='security_code' value='' size=4 maxlength=4></td>
                        <td></td>
                        <!--
                        <td>Payment Amount</td>
                        <td><input name="CardAmount" id="CardAmount" type="text" size=4/></td>
                        -->
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="mpesa">
            <table class="table" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td></td>
                    <td width="24%">Transaction Number:</td>
                    <td></td>
                    <td width="30%"><input type='text' name='MpesaRef' value='' size=20 maxlength=100/>  </td>
                    <!--
                    <td width="20%">Amount:</td>
                    <td width="26%">
                        <input name="MpesaAmount" id="MpesaAmount" type="text" size=5  />
                    </td>
                    -->
                </tr>
            </table>
        </div>
        <div id="cheque">
            <div class="element atStart">
                <table class="table" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td></td>
                        <td width="20%">Ac Holder Name: </td>
                        <td width="30%"><input name="ChequeName" type="text" size=20 maxlength=100/></td>
                        <td width="20%">Date on Cheque Leaf: </td>
                        <td width="30%"><input name="ChequeDate" type="text"  size=20 class="datepicker"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <!--
                        <td width="20%">Amount: </td>
                        <td width="30%"><input name="ChequeAmount" type="text" /></td>
                        -->
                        <td width="20%">Cheque Number: </td>
                        <td width="30%"><input name="ChequeNumber" id="ChequeAmount" type="text" /></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>Bank</td>
                        <td><input name="Bank" type="text" /></td>
                        <td>Branch:</td>
                        <td><input type='text' name='Branch' value='' size=20 maxlength=100></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>
        </div>


    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".date1").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: '0'
            });

            $(".date2").datepicker({
                dateFormat: 'yy-mm-dd',
                maxDate: '0'
            });
        });
    </script>
</div>