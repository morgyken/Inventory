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
?>

@extends('layouts.app')
@section('content_title','Purchase Orders')
@section('content_description','View and create LPO\'s')

@section('content')
{!! Form::open(['class'=>'form-horizontal']) !!}
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            <a href="{{route('inventory.new_lpo')}}" class="btn btn-sm btn-primary">
                <i class="fa fa-plus-square-o"></i> Create LPO</a></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['orders']->isEmpty())
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Status</th>
                            <th>Delivery date</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['orders'] as $order)
                        <tr>
                            <td>{{$order->suppliers->name}}</td>
                            <td>{{$order->status_label}}</td>
                            <td>{{$order->deliver_date}}</td>
                            <td>{{$order->totals}}</td>
                            <td><a href="{{route('inventory.order_details',$order->id)}}" class="btn btn-xs btn-primary">
                                    <i class="fa fa-eye-slash"></i> View</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No purchase orders</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection