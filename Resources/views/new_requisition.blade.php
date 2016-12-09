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
//$lpo = $data['lpo'];
?>

@extends('layouts.app')
@section('content_title','Make Item Requisition')
@section('content_description','')

@section('content')
<div class="box box-info">
    {!! Form::open(['class'=>'form-horizontal', 'route'=>'inventory.requisition.save']) !!}
    <div class="box-header with-border">
        <h3 class="box-title">Select an item/items that need to be re-stocked</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <table class="items table  table-striped table-condensed" id="tab_logic">
                    <thead>
                        <tr>
                            <th style="width: 50%;">Item</th>
                            <th class="text-center" style="width: 10%;">Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id='addr0'>
                            <td><select name="item0" class=" select2-single" style="width: 100%"></select></td>
                            <td><input type="text" name='qty0' placeholder='Quantity' value="1"/></td>
                            <td></td>
                        </tr>
                        <tr id='addr1'></tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><a id="add_row" class="btn btn-primary btn-sm pull-left"><i class="fa fa-plus"></i> Add</a>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-xs-4 col-form-label">Description/Reason</label>
                </div>
                <div class="form-group row">
                    <div class="col-xs-12">
                        <textarea name = "description" class="form-control" placeholder = "Description of requisition or why">
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="pull-right">
            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa fa-send-o"></i> Make Requisition
            </button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<script type="text/javascript">
    var PRODUCTS_URL = "{{route('api.inventory.get_products')}}";
</script>
<script src="{!! m_asset('inventory:js/req.js') !!}"></script>
@endsection