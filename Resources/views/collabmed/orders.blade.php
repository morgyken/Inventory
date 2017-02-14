<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: bravo kiptoo <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>

@extends('layouts.app')

@section('content_title','Orders to Collabmed')
@section('content_description','')

@section('content')
<div class="box box-info">
    <!--
    <div class="box-header with-border">
        <h3 class="box-title"><a class="btn btn-primary btn-xs" href="{{route('inventory.manage_suppliers')}}">
                <i class="fa fa-plus-square"></i> Add supplier
            </a> </h3>
    </div>
    -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['orders']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['orders'] as $order)
                        <tr id="supplier{{$order->id}}">
                            <td>{{$order->id}}</td>
                            <td>{{$order->client}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>
                                <a href="{{route('inventory.collabmed.order.view', $order->id)}}"
                                   class="btn btn-primary btn-xs">
                                    <i class="fa fa-edit"></i> view</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No Orders Received</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        $('.table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endsection