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
@section('content_title','Clients')
@section('content_description','View and manage clients')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Clients </h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['ins']->isEmpty())
                <table class="table table-responsive table-striped" id="clients">
                    <tbody>
                        <?php $n = 0; ?>
                        @foreach($data['ins'] as $ins)
                        <?php $n+=1; ?>
                        <tr>
                            <td>{{$n}}</td>
                            <td>{{$ins->clients->first_name}} {{$ins->clients->last_name}}</td>
                            <td>{{$ins->policy_no}}</td>
                            <td>{{$ins->schemes->name}}</td>
                            <td>
                                <a href="{{route('inventory.clients.credit', $ins->id)}}">
                                    <i style="color: green" class="fa fa-pencil"></i>
                                </a>
                            </td>
                            <td><a href="{{route('inventory.clients.credit.purge', $ins->clients->id)}}"><i style="color: red" class="fa fa-trash"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Policy Number</th>
                            <th>Insurance Scheme</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No Clients Yet</p>
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
            $('#clients').dataTable();
        } catch (e) {
        }
    });
</script>
@endsection