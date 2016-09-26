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
@section('content_title','Receive Goods')
@section('content_description','Receive goods')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Receive goods </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <a class="btn btn-sm btn-primary"
                   href="{{route('inventory.receive_direct')}}">Receive goods directly from supplier</a>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if(!$data['lpos']->isEmpty())
                <h4>Or, Select an existing LPO</h4>
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
                        @foreach($data['lpos'] as $order)
                        <tr>
                            <td>{{$order->suppliers->name}}</td>
                            <td>{{$order->status}}</td>
                            <td>{{$order->deliver_date}}</td>
                            <td>{{$order->totals}}</td>
                            <td><a href="{{route('inventory.receive_from_lpo',$order->id)}}"
                                   class="btn btn-xs btn-success">
                                    <i class="fa fa-hand-grab-o"></i> Receive Goods</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p>No active purchase orders</p>
                @endif
                <p class="text-warning"> <i class="fa fa-warning"></i> LPO's that are yet to be approved won't appear here.</p>
            </div>
        </div>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['deliveries']->isEmpty())
                <table class="table table-responsive table-striped" id="deliveries">
                    <tbody>
                        @foreach($data['deliveries'] as $del)
                        <tr>
                            <td>{{$del->id}}</td>
                            <td>
                                @if($del->supplier>0)
                                {{$del->suppliers->name}}
                                @endif
                            </td>
                            <td>{{$del->users->username}}</td>
                            <td>{{$del->created_at}}</td>
                            <td><a href="{{route('inventory.batch.details', $del->id)}}"> <i class="fa fa-plus-square-o"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>Delivery</th>
                            <th>Supplier</th>
                            <th>Received By</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No Deliveries Yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('select').select2();
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('#deliveries').dataTable();
        } catch (e) {
        }
    });
</script>
@endsection