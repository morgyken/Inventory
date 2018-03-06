<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author:Bravo Kiptoo (bkiptoo@collabmed.com)
 *
 * =============================================================================
 */
?>

@extends('layouts.app')
@section('content_title','Stock Movement')
@section('content_description','Overview of an item\'s movement in store')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Stock Movement</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['adjustments']->isEmpty())
                <table id="table" class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Patient</th>
                            <th>Opening Stock</th>
                            <th style="text-align: center">Change</th>
                            <th>Closing Stock</th>
                            <th>Type</th>
                            <th>By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $n = 0; ?>
                        @foreach($data['adjustments'] as $adj)
                        <tr id="category{{$adj->id}}">
                            <td>{{$n+=1}}</td>
                            <td>{{$adj->products->name}}</td>
                            <td>{{$adj->products->name}}</td>
                            <td>{{$adj->opening_qty}}</td>
                            <td style="text-align: center">
                                {{$adj->quantity}} {{$adj->method=='+'?"In(+)":"Out(-)"}}
                            </td>
                            <td>{{$adj->closing}}</td>
                            <td>{{$adj->type}}</td>
                            <td>{{$adj->users?$adj->users->username:'-'}}</td>
                            <td>{{$adj->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No stock has moved yet!</p>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('#table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
        } catch (e) {
        }
    });

    var APPROVE_URL = "{{route('api.inventory.adj_approve')}}";
    function approveAdj(id) {
        $.ajax({
            type: "get",
            url: APPROVE_URL,
            data: {id: id},
            beforeSend: function () {
                $('#feedback' + id).css("background", "#FFF");
            },
            success: function (data) {
                $("#feedback" + id).html(data)
                //$('#item_qty_' + i).css("background", "#FFF");
            }
        });
    }
</script>
@endsection