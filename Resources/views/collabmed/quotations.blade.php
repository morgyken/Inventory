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
                @if(!$data['quots']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['quots'] as $q)
                        <tr id="supplier{{$q->id}}">
                            <td>{{$q->id}}</td>
                            <td>{{$q->suppliers->name}}</td>
                            <td>{{$q->created_at}}</td>
                            <td>
                                @if($q->status=='rejected')
                                <span class="label label-danger">{{$q->status}}</span>
                                @elseif($q->status=='accepted')
                                <span class="label label-success">{{$q->status}}</span>
                                @else
                                <span class="label label-info">{{$q->status}}</span>
                                @endif

                                @if($q->status==null)
                                <span class="label label-warning">pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('inventory.collabmed.quotation.details', $q->id)}}"
                                   class="btn btn-primary btn-xs">
                                    <i class="fa fa-edit"></i> view</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th></th>
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