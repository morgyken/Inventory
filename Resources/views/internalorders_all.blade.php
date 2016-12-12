<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Gidi (bkiptoo@collabmed.com)
 *
 * =============================================================================
 */
?>

@extends('layouts.app')

@section('content_title','New Store')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><a class="btn btn-primary btn-xs" href="{{route('inventory.new.order.internal')}}">
                <i class="fa fa-plus-square"></i> New Internal Order
            </a>
        </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['orders']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['orders'] as $item)
                        <tr id="supplier{{$item->id}}">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->users->username}}</td>
                            <td>{{$item->disp_store->name}}</td>
                            <td>{{$item->rq_store->name}}</td>
                            <td>
                                @if($item->status ===0)
                                <span  class="btn-info btn-xs">
                                    <small>
                                        <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                        pending
                                    </small>
                                </span>
                                @else
                                <span  class="btn-success btn-xs">
                                    <small>
                                        <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                        closed
                                    </small>
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Dispatching Store</th>
                            <th>Requesting Store</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No records to show</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
        } catch (e) {
        }
    });
</script>
@endsection