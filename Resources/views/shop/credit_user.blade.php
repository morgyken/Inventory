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
if (isset($data['ins'])) {
    $ins = $data['ins'];
} else {
    $ins = null;
}
?>
@extends('layouts.app')
@section('content_title','Insurance Client')
@section('content_description','Create and manage insurance clients')

@section('content')
<div class="box box-info">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="direct">
                        <form method="post" action="{{route('inventory.clients.credit',null)}}" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('payment_mode') ? ' has-error' : '' }} req">
                                        <div>
                                            <input type="hidden" value="insurance" name="payment_mode" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="insurance">
                                <div id="wrapper1">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend>Client Information:</legend>
                                            <div class="form-group">
                                                <div class="col-md-4"><label>First Name</label></div>
                                                <div class="col-md-8">
                                                    <input type="hidden" name="client_id" value="{{$ins['clients']['id']}}">
                                                    <input type="hidden" name="ins_id" value="{{$ins['id']}}">
                                                    <input type="text" id="fname1" placeholder="First Name" value="{{$ins['clients']['first_name']}}" name="first_name_ins" autocomplete="off" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-4"><label>Last Name</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="lname1" placeholder="Last Name" value="{{$ins['clients']['last_name']}}" name="last_name_ins" autocomplete="off" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-4"><label>Date Of Birth</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" id="user_dob" placeholder="User Date of Birth" value="{{$ins['clients']['date_of_birth']}}" name="dob_user" class="form-control date1">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-4"><label>Phone Number</label></div>
                                                <div class="col-md-8">
                                                    <input type="text" placeholder="Phone Number" id="phone1" value="{{$ins['clients']['phone']}}" name="phone_ins" autocomplete="off" class="form-control" />
                                                    <div id="suggesstion-box1"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-md-4"><label>Email Address</label></div>
                                                <div class="col-md-8">
                                                    <input type="email" id="email1" placeholder="Email Address" value="{{$ins['clients']['email']}}" autocomplete="off" name="email_ins" class="form-control">
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <legend>Principl's Details:</legend>
                                            <div class="form-group {{ $errors->has('principal') ? ' has-error' : '' }}">
                                                {!! Form::label('principal', 'Principal',['class'=>'control-label col-md-4']) !!}
                                                <div class="col-md-8">
                                                    {!! Form::text('principal', $ins['principal'], ['class' => 'form-control', 'placeholder' => 'Principal Name']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('principal_dob') ? ' has-error' : '' }}">
                                                {!! Form::label('principal_dob', 'Principal Date of Birth',['class'=>'date control-label col-md-4']) !!}
                                                <div class="col-md-8">
                                                    {!! Form::text('principal_dob', $ins['date_of_birth'], ['class' => 'form-control date2', 'placeholder' => 'Principal Date of Birth']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('principal_relationship') ? ' has-error' : '' }}">
                                                {!! Form::label('principal_relationship', 'Relationship',['class'=>'control-label col-md-4']) !!}
                                                <div class="col-md-8">
                                                    {!! Form::select('principal_relationship',config('system.relationship'), $ins['relation'], ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend>Insurance Scheme Details:</legend>
                                            <div class="form-group {{ $errors->has('company') ? ' has-error' : '' }}">
                                                {!! Form::label('company', 'Insurance Company',['class'=>'control-label col-md-4']) !!}
                                                <div class="col-md-8">
                                                    {!! Form::select('company',get_insurance_companies(), null, ['class' => 'form-control company', 'placeholder' => 'Choose...']) !!}
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('scheme') ? ' has-error' : '' }}">
                                                {!! Form::label('scheme', 'Credit Schemes',['class'=>'control-label col-md-4']) !!}
                                                <div class="col-md-8">
                                                    <select name="scheme" id="scheme" class="form-control">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group {{ $errors->has('policy_number') ? ' has-error' : '' }}">
                                                {!! Form::label('policy_number', 'Policy Number',['class'=>'control-label col-md-4']) !!}
                                                <div class="col-md-8">
                                                    {!! Form::text('policy_number', $ins['policy_no'], ['class' => 'form-control', 'placeholder' => 'Policy Number']) !!}
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="pull-right">
                                    <button type="submit" id="save" class="btn btn-success">
                                        <i class="fa fa-send"></i>Save Client
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                    </div><!--End of Direct-->
                </div><!--End of tab content -->
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
<script>
    // AJAX call for autocomplete
    $(document).ready(function () {
        var scheme_id = 0;
        $('#scheme').change(function () {
            scheme_id = $(this).val();
            console.log(scheme_id);
        });
    });
    var INSURANCE = true;
    var STOCK_URL = "{{route('inventory.ajax.getstock')}}";
    var PRODUCTS_URL = "{{route('inventory.ajax.get.products')}}";
    var SCHEMES_URL = "{{route('ajax.get_schemes')}}";
    var PHONE_URL = "{{route('inventory.ajax.cust.get')}}";
    var CREDIT_URL = "{{route('inventory.ajax.credit.rate')}}";
</script>
<script src="{!! m_asset('inventory:js/shopfront.js') !!}"></script>
@endsection