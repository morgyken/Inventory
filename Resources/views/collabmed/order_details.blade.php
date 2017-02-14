<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo
 *
 * =============================================================================
 */
$order = $data['order'];
?>

@extends('layouts.app')
@section('content_title','Order Details')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Order details</h3>
    </div>
    <div class="box-body">
        {!! Form::open(['route'=>'inventory.collabmed.quotation','class'=>'form-horizontal'])!!}
        <dl class="dl-horizontal">
            <dt>Order#:</dt>
            <dd>{{$data['col_order']}}</dd>
            <dt>Supplier:</dt>
            <dd>
                <div class="col-md-4">
                    {!! Form::select('supplier',get_suppliers(),$order->suppliers->id,['class'=>'form-control']) !!}
                    {!! $errors->first('supplier', '<span class="help-block">:message</span>') !!}
                </div>
                <input type="hidden" name="order" value="{{$data['col_order']}}">
            </dd>
            <dt>Delivery Date:</dt>
            <dd>{{smart_date($order->deliver_date)}}</dd>
            <dt>Order Date:</dt>
            <dd>{{smart_date($order->created_at)}}</dd>
            <dt>Order Status</dt><dd><span class="label label-success">{{$order->status_label}}</span></dd>
        </dl>
        <div>
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->details as $item)
                    <tr>
                        <td>
                            {{$item->products->name}}
                            <input type="hidden" name="item[]" value="{{$item->id}}">
                        </td>
                        <td>
                            {{$item->quantity}}
                            <input type="hidden" name="required_units[]" value="{{$item->quantity}}">
                        </td>
                        <td>{{number_format($item->price,2)}}</td>
                        <td>{{$item->total}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>{{$order->totals}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="box-footer">
            <div class="btn-group ">
                <div class="form-group {{ $errors->has('supplier') ? ' has-error' : '' }} req">
                    <button class="btn btn-warning"><i  class="fa fa-list"></i>Receive Quotation</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'pdf', 'print'
            ]
        });
    });
</script>
@endsection