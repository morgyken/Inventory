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
@section('content_title','Stock Adjustments')
@section('content_description','Overview of stock adjustments')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Stock Adjustments</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['adjustments']->isEmpty())
                <table id="table" class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th><center>Quantity</center></th>
                    <th><center>Method</center></th>
                    <th>Type</th>
                    <th>By</th>
                    <th>Approved?</th>
                    <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data['adjustments'] as $adj)
                        <tr id="category{{$adj->id}}">
                            <td>{{$adj->products->name}}</td>
                            <td><center>{{$adj->quantity}}</center></td>
                    <td><center>{{$adj->method}}</center></td>
                    <td>{{$adj->type}}</td>
                    <td>{{$adj->users?$adj->users->username.'('.$adj->users->email.')':'-'}}</td>
                    <td id="feedback{{$adj->id}}">
                        <?php
                        if ($adj->approved === 'no')
                            echo "no <a onclick='approveAdj($adj->id)'>approve?</a>";
                        elseif ($adj->approved === 'yes')
                            echo "yes";
                        else
                        //Do Nothing

                            ?>
                    </td>
                    <td>{{$adj->created_at}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No Stock Adjustments yet!</p>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('#table').dataTable();
        } catch (e) {
        }
    });

    var APPROVE_URL = "{{route('inventory.ajax.adj_approve')}}";
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