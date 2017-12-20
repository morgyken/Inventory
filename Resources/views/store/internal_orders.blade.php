<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: KIPTOO BRAVO <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>

@extends('layouts.app')
@section('content_title','Internal Orders')
@section('content_description','Manage internal orders')

@section('content')
<div class="box box-info">
    {!! Form::open(['class'=>'form-horizontal','route'=>'inventory.store.save_order']) !!}
    <div class="box-header with-border">
        <h3 class="box-title">Order details</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store') ? ' has-error' : '' }} req">
                    <label class="col-md-4">Dispatching Store</label>
                    <div class="col-md-8">
                        <select name="dispatching_store" class="form-control">
                            @foreach($data['stores'] as $store)
                            <option value="{{$store->id}}">{{$store->name}}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('store', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('store') ? ' has-error' : '' }} req">
                    <label class="col-md-4">Requesting Store</label>
                    <div class="col-md-8">
                        <select name="requesting_store" class="form-control">
                            @foreach($data['stores'] as $store)
                            <option value="{{$store->id}}">{{$store->name}}</option>
                            @endforeach
                        </select>
                        {!! $errors->first('store', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group {{ $errors->has('deliver_date') ? ' has-error' : '' }} req">
                    {!! Form::label('deliver_date', 'Delivery Date',['class'=>'col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('delivery_date', old('delivery'), ['class' => 'form-control date']) !!}
                        {!! $errors->first('deliver_date', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="items table  table-striped" id="tab_logic">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th class="text-center" style="width: 10%;">Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id='addr0'>
                            <td><select name="item0" class=" select2-single" style="width: 100%"></select></td>
                            <td><input type="text" name='qty0' placeholder='Quantity' value="1"/></td>
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
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="pull-right">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa fa-send-o"></i> Continue
            </button>
        </div>
    </div>
</form>
</div>
<script type="text/javascript">
    var PRODUCTS_URL = "{{route('api.inventory.get_products')}}";
</script>
<script src="{!! m_asset('inventory:js/inorder_stub.js') !!}"></script>
@endsection