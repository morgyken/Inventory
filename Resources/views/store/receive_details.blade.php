<?php
extract($data);
/** @var \Ignite\Inventory\Entities\InternalOrder $order */
?>

@extends('layouts.app')
@section('content_title','View Order')
@section('content_description','View order details')

@section('content')
    <div class="box box-info">
        {!! Form::open(['route'=>'inventory.store.save_receive']) !!}
        {!! Form::hidden('order_id',$order->id)!!}
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
                        <th>#</th>
                        <th>Item</th>
                        <th>Dispatched</th>
                        <th>Received</th>
                        <th>Rejected</th>
                        <th>Reason</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->details as $item)
                        @foreach($item->dispatch as $d)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->product->name}}</td>
                                <td>{{$d->qty_dispatched}}</td>
                                <td><input type="text" name="receive[<?=$d->id?>]" value="{{$d->qty_dispatched}}"></td>
                                <td><input type="text" name="reject[<?=$d->id?>]" value="0"></td>
                                <td><input type="text" name="reason[<?=$d->id?>]" placeholder="Mbona?">
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>


            </div>
        </div>
        <div class="box-footer">
            <div class="pull-left">
                <a href="{{route('inventory.store.receive')}}" class="btn btn-default">
                    <i class="fa fa-arrow-left"></i>
                    Back</a>
            </div>
            <div class="pull-right">
                <button class="btn btn-success"><i class="fa fa-send"></i> Accept Items</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection