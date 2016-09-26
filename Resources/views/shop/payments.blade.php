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
                            {!! Form::select('payment_mode',config('inventory.payment_modes'),null,['class'=>'form-control payment', 'required','id'=>'payment_mode']) !!}
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
        <div id="insurance">
            <div id="wrapper1">

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-4"><label>Phone Number</label></div>
                        <div class="col-md-8">
                            <input type="text" placeholder="Phone Number" id="phone1" value="" name="phone_ins" autocomplete="off" class="form-control" />
                            <div id="suggesstion-box1"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4"><label>First Name</label></div>
                        <div class="col-md-8">
                            <input type="text" id="fname1" placeholder="First Name" value="" name="first_name_ins" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4"><label>Last Name</label></div>
                        <div class="col-md-8">
                            <input type="text" id="lname1" placeholder="Last Name" value="" name="last_name_ins" autocomplete="off" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-4"><label>Email Address</label></div>
                        <div class="col-md-8">
                            <input type="email" id="email1" placeholder="Email Address" value="" autocomplete="off" name="email_ins" class="form-control">
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-4"><label>User Date Of Birth</label></div>
                        <div class="col-md-8">
                            <input type="text" id="user_dob" placeholder="User Date of Birth" value="" name="dob_user" class="form-control date1">
                        </div>
                    </div>

                </div>


                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('company') ? ' has-error' : '' }}">
                        {!! Form::label('company', 'Insurance Company',['class'=>'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::select('company',get_insurance_companies(), null, ['class' => 'form-control company', 'placeholder' => 'Choose...']) !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('scheme') ? ' has-error' : '' }}">
                        {!! Form::label('scheme', 'Credit Schemes',['class'=>'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            <select name="scheme" class="form-control">
                                @foreach($data['schemes'] as $s)
                                <option value="{{$s->id}}">{{$s->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('policy_number') ? ' has-error' : '' }}">
                        {!! Form::label('policy_number', 'Policy Number',['class'=>'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::text('policy_number', null, ['class' => 'form-control', 'placeholder' => 'Policy Number']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('principal') ? ' has-error' : '' }}">
                        {!! Form::label('principal', 'Principal',['class'=>'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::text('principal', null, ['class' => 'form-control', 'placeholder' => 'Principal Name']) !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('principal_dob') ? ' has-error' : '' }}">
                        {!! Form::label('principal_dob', 'Principal Date of Birth',['class'=>'date control-label col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::text('principal_dob', null, ['class' => 'form-control date2', 'placeholder' => 'Principal Date of Birth']) !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('principal_relationship') ? ' has-error' : '' }}">
                        {!! Form::label('principal_relationship', 'Relationship',['class'=>'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::select('principal_relationship',config('system.relationship'), null, ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                        </div>
                    </div>
                </div>
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