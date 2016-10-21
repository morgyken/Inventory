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
$order = $data['order'];
$count = 0;
?>


@extends('layouts.app')
@section('content_title','Receive Goods from LPO.')
@section('content_description','Receive goods from LPO')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <div>
            <dl class="dl-horizontal">
                <dt>Supplier:</dt>
                <dd>{{$order->suppliers->name}}</dd>
                <dt>Order Status:</dt>
                <dd><span class="label label-primary">{{$order->status_label}}</span></dd>
                <dt>Delivery Date:</dt>
                <dd>{{$order->deliver_date}}</dd>
                <dt>Ordered Amount:</dt>
                <dd>{{$order->totals}}</dd>
            </dl>
        </div>
    </div>
    <div class="box-body">
        {!! Form::open() !!}
        {!! Form::hidden('lpo',$order->id) !!}
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="supplier" value="{{$order->suppliers->id}}">
                <table class="items table  table-striped table-condensed" id="tab_logic">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Bonus</th>
                            <th>Package Size</th>
                            <th>Expiry Date</th>
                            <th>Unit cost (Kshs)</th>
                            <th>Discount (%)</th>
                            <th>Tax(%)</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $line)
                        <tr id='addr{{$count}}'>
                            <td>{{$line->products->name}} {!! Form::hidden("item".$count,$line->product) !!}</td>
                            <td><input type="text" name='qty{{$count}}' placeholder='Quantity'
                                       value="{{$line->quantity}}" size="2"/></td>
                            <td><input type="text" name='bonus{{$count}}' placeholder='Bonus' value="0" size="2"/>
                            </td>
                            <td><input type="text" value="1" name='package{{$count}}' placeholder='Product Packaging' /></td>
                            <td><input type="text" onclick="pick_date({{$count}})" id="expiry{{$count}}" name='expiry{{$count}}' placeholder='Expiry Date'/></td>
                            <td><input type="text" name='price{{$count}}' placeholder='Price' size="4"
                                       value="{{$line->price}}"/></td>
                            <td><input type="text" name='dis{{$count}}' placeholder='eg. 2'
                                       value="0" size="2"/></td>
                            <td><input type='text' onchange="calculate_total()" name='tax{{$count}}' placeholder='' value='{{$line->products->taxgroups?$line->products->taxgroups->rate:0}}' size='3'/></td>
                            <td><span id="total{{$count}}">{{$line->total}}</span></td>
                        </tr>
                        <?php $count++; ?>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th colspan="6">Grand Total</th>
                            <th><strong id="net">0.00</strong></th>
                        </tr>
                    </tfoot>
                </table>
                <div>
                    <button class="btn btn-sm btn-primary">Receive Goods</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script type="text/javascript">
    function pick_date(id) {
    $(document).ready(function () {
    $("#expiry" + id).datepicker({dateFormat: 'yy-mm-dd', minDate: 0, onSelect: function (date) {
    }});
    });
    }
</script>
<script src="{!! m_asset('inventory:js/receive_goods.js') !!}"></script>
@endsection