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
$product = $data['product'];
?>

@extends('layouts.app')
@section('content_title','Adjust Stock')
@section('content_description','Manage stock levels')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Update stock for product #{{$product->id}} - {{$product->name}}</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <dl class="dl-horizontal">
                        <dt>Product id</dt>
                        <dd>{{$product->product_code}}</dd>
                        <dt>Product Name</dt>
                        <dd>{{$product->name}}</dd>
                        <dt>Product Category</dt>
                        <dd>{{$product->categories?$product->categories->name:'None'}}</dd>
                        <dt>Unit of measurement</dt>
                        <dd>{{$product->units->name}}</dd>
                        <dt>Current Stock</dt>
                        <dd>{{$product->stocks ?$product->stocks->quantity: '0'}}</dd>
                        <dt>Last stock update</dt>
                        <dd>{{$product->stocks?$product->stocks->updated_at: '0'}}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    {!! Form::open(['class'=>'form-horizontal']) !!}
                    <div class="form-group {{ $errors->has('quantity') ? ' has-error' : '' }} req">
                        <label class="control-label col-md-4">New quantity</label>
                        <div class="col-md-8">
                            <input type="text" name="quantity" class="form-control" value="{{old('quantity')}}"
                                   />
                            {!! $errors->first('quantity', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('reason') ? ' has-error' : '' }} req">
                        <label class="control-label col-md-4">Reason</label>
                        <div class="col-md-8">
                            <textarea name="reason"
                                      class="form-control">{{old('description')}}</textarea>
                            {!! $errors->first('reason', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>



    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['adjustments']->isEmpty())
                <table id="table" class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th><center>Quantity</center></th>
                    <th><center>Method</center></th>
                    <th>Type</th>
                    <th>By</th>
                    <th>Approved?</th>
                    <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data['adjustments'] as $adj)
                        <tr id="category{{$adj->id}}">
                            <td>{{$adj->products?$adj->products->name:'-'}}</td>
                            <td><center>{{$adj->quantity}}</center></td>
                    <td><center>{{$adj->method}}</center></td>
                    <td>{{$adj->type}}</td>
                    <td>{{$adj->users?$adj->users->username.'('.$adj->users->email.')':'-'}}</td>
                    <td id="feedback{{$adj->id}}">
                        <?php
                        if ($adj->approved === 'no')
                            echo "no <a onclick='approveAdj($adj->id)'>approve?</a>";
                        elseif ($adj->approved === 'yes')
                            echo "yes";
                        else
                        //Do Nothing

                            ?>
                    </td>
                    <td>{{$adj->created_at}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No Stock Adjustments yet!</p>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('#table').dataTable();
        } catch (e) {
        }
    });

    var APPROVE_URL = "{{route('inventory.ajax.adj_approve')}}";
    function approveAdj(id) {
        $.ajax({
            type: "get",
            url: APPROVE_URL,
            data: {id: id},
            beforeSend: function () {
                $('#feedback' + id).css("background", "#FFF");
            },
            success: function (data) {
                $("#feedback" + id).html(data)
                //$('#item_qty_' + i).css("background", "#FFF");
            }
        });
    }
</script>
@endsection