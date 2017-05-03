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

function amount_after_discount($discount, $amount) {
    try {
        $discounted = $amount - (($discount / 100) * $amount);
        return ceil($discounted);
    } catch (\Exception $e) {
        return $amount;
    }
}

$total = 0;
?>

@extends('layouts.app')
@section('content_title','Point of sale')
@section('content_description','Sales note ')


@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Items dispensed</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <tr>
                        <th>Sale ID</th>
                        <th>Receipt Number</th>
                        <th>Client</th>
                    </tr>
                    <tr>
                        <td>{{$data['sales']->id}}</td>
                        <td>{{$data['sales']->receipt}}</td>
                        <td>{{$data['sales']->patients?$data['sales']->patients->full_name:'Not Selected'}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><i><u>Give sale id to client and direct them to Cashier.</u></i></td>
                    </tr>
                </table>
                <table class="table table-striped table-condensed">
                    <tbody>
                        @foreach($data['sales']->goodies as $item)
                        <?php
                        $total+=ceil($item->total);
                        ?>
                        <tr>
                            <td>{{$item->products->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{ceil(number_format($item->unit_cost,2))}}</td>
                            <td>{{$item->discount}}</td>
                            <td>{{ceil($item->total)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount (%)</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th style="text-align:right" colspan="4">Total</th>
                            <th>{{number_format($total,2)}}</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="btn-group">
                    @if($data['sales']->payment_mode=='insurance')
                    <a href="{{route('inventory.sale.invoice.print',$data['sales']->id)}}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-print"></i> Print Insurance Invoice
                    </a>
                    @else
                    <!--
                    <a href="{{route('inventory.sale.receipt.print',$data['sales']->id)}}" target="_blank" class="btn btn-primary">
                        <i class="fa fa-print"></i> Print Receipt</a>
                    -->
                    @endif
                    <a href="{{route('inventory.shopfront')}}" class="btn btn-success">
                        <i class="fa fa-fast-forward"></i> Next Sales</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .strike{
        color:red;
        text-decoration:line-through;
    }
</style>
@endsection
