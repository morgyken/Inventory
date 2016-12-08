<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo (bkiptoo@gmail.com)
 *
 * =============================================================================
 */
?>
@extends('layouts.app')
@section('content_title','Item Requisitions')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Item Requisitions </h3>
    </div>

    <div class="box-body">
        @if(isset($data['details']))
        <div class="row">
            <div class="col-md-6">
                <h4>Requisition#: {{$data['clicked']->id}}</h4>
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['details'] as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->items->name}}</td>
                            <td>{{$item->quantity}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Requested Quantity</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="col-md-6">
                <h4>Reason/Description</h4>
                <p>
                    {{$data['clicked']['reason']?$data['clicked']['reason']:'No details given' }}
                </p>
            </div>
        </div>
        <hr>
        @endif
        <div class="row">
            <div class="col-md-12">
                @if(!$data['requisitions']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['requisitions'] as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>00{{$item->id}}</td>
                            <td>{{$item->users->username}}</td>
                            <td>{{$item->item_count}}</td>
                            <td>{{$item->created_at}}</td>
                            <td style="text-align: center">
                                <?php
                                if ($item->status === 1) {
                                    echo '<i class="fa fa-check"></i>';
                                } else {
                                    echo '<i class="fa fa-cog fa-spin"></i>pending';
                                }
                                ?>
                            </td>
                            <td>
                                <small>
                                    <a href="{{route('inventory.requisition.view', $item->id)}}" class="btn-xsm label-info">
                                        <i class="fa fa-plus-square-o">Details</i>
                                    </a>|
                                </small>
                                <small>
                                    <a href="{{route('inventory.req.lpo', $item->id)}}" class="btn-xsm label-success">Create LPO</a>
                                </small>|
                                <small>
                                    <a href="{{route('inventory.requisition.cancel', $item->id)}}" class="btn-xsm label-warning">Mark as Settled</a>
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Requisition ID</th>
                            <th>By</th>
                            <th>Items Requested</th>
                            <th>Date</th>
                            <th style="text-align: center">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No Requisitions have been made so far</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('table').dataTable();
        } catch (e) {
        }
    });
</script>
@endsection