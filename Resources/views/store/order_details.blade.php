<?php
extract($data);
/** @var \Ignite\Inventory\Entities\InternalOrder $order */
?>

@extends('layouts.app')
@section('content_title','View Order')
@section('content_description','View order details')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Order details</h3>
        </div>
        <div class="box-body">
            <dl class="dl-horizontal">
                <dt>From:</dt>
                <dd>{{$order->disp_store->name}}</dd>
                <dt>To:</dt>
                <dd>{{$order->rq_store->name}}</dd>
                <dt>Delivery Date:</dt>
                <dd>{{smart_date($order->deliver_date)}}</dd>
                <dt>Order Date:</dt>
                <dd>{{smart_date($order->created_at)}}</dd>
                <dt>Order Status</dt>
                <dd><span class="label label-success">{{$order->status_label}}</span></dd>
            </dl>
            <div>
                <table class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->details as $item)
                        <tr>
                            <td>{{$item->product->name}}</td>
                            <td>{{$item->quantity}}</td>
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
                    @if($order->status != 0)
                        <a href="{{route('inventory.print_lpo',$order->id)}}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-print"></i> Print</a>
                    @endif
                    @if($order->status == 0)
                        <a href="{{route('inventory.approveLPO',$order->id)}}" class="btn btn-info">
                            <i class="fa fa-check-circle-o"></i>Approve</a>
                    @elseif($order->status == 1)
                    <!--
                <a href="{{route('inventory.to_collabmed',$order->id)}}" class="btn btn-warning">
                    <i  class="fa fa-list"></i> Send to Collabmed</a>
                -->
                        <a href="{{route('inventory.receive_from_lpo',$order->id)}}" class="btn btn-success">
                            <i class="fa fa-hand-lizard-o"></i> Receive Goods</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection