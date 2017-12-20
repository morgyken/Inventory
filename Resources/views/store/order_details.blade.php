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
                <dd>{{$order->nice_status}}</dd>
            </dl>
            <div>
                <table class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Ordered</th>
                        <th>Dispatched</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->details as $item)
                        <tr>
                            <td>{{$item->product->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->dispatched??0}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection