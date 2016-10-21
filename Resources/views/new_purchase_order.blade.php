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
$lpo = $data['lpo'];
?>

@extends('layouts.app')
@section('content_title','Manage LPO')
@section('content_description','LPO Details')

@section('content')
<div class="box box-info">
    {!! Form::open(['class'=>'form-horizontal']) !!}
    <div class="box-header with-border">
        <h3 class="box-title">Order details</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4 col-md-offset-1">
                <div class="form-group {{ $errors->has('supplier') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Supplier</label>
                    <div class="col-md-8">
                        {!! Form::select('supplier',get_suppliers(),null,['class'=>'form-control']) !!}
                        {!! $errors->first('supplier', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                    {!! Form::label('name', 'Delivery Date',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('delivery_date', old('delivery'), ['class' => 'form-control date']) !!}
                        {!! $errors->first('delivery', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-md-offset-1">
                <div class="form-group {{ $errors->has('payment_terms') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Payment Terms</label>
                    <div class="col-md-8">
                        {!! Form::select('payment_terms',get_payment_terms(),old('payment_terms'),['class'=>'form-control']) !!}
                        {!! $errors->first('payment_terms', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('payment_mode') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Payment Mode</label>
                    <div class="col-md-8">
                        {!! Form::select('payment_mode',mconfig('inventory.options.payment_modes'),old('payment_mode'),['class'=>'form-control']) !!}
                        {!! $errors->first('payment_mode', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="items table  table-striped table-condensed" id="tab_logic">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Item</th>
                            <th class="text-center" style="width: 10%;">Quantity</th>
                            <th class="text-center" style="width: 20%;">Price</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id='addr0'>
                            <td><select name="item0" class=" select2-single" style="width: 100%"></select></td>
                            <td><input type="text" name='qty0' placeholder='Quantity' value="1"/></td>
                            <td><input type="text" name='price0' placeholder='Price'/></td>
                            <td><span id="total0">0.00</span></td>
                            <td>
                                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                        <tr id='addr1'></tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><a id="add_row" class="btn btn-primary btn-sm pull-left"><i class="fa fa-plus"></i> Add</a>
                            </td>
                            <td></td>
                            <td></td>
                            <td><strong id="total">0.00</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="pull-right">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa fa-send-o"></i> Create LPO
            </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script type="text/javascript">
    var PRODUCTS_URL = "{{route('api.inventory.get_products')}}";
</script>
<script src="{!! m_asset('inventory:js/lpo_stub.min.js') !!}"></script>
@endsection