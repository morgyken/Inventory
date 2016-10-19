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
@section('content_title','Return sold items')
@section('content_description','Sales return ')


@section('content')
<style>
    label{
        text-align: right;
    }
</style>
<div class="box box-info">
    <form class="form-horizontal" method="post" action="{{ route('inventory.sales.return')}}">
        {!! Form::open(['class'=>'form-horizontal']) !!}
        <div class="box-header with-border">
            <h3 class="box-title">Select a receipt number to continue</h3>
        </div>
        <div class="box-body">

            <div class="row">
                <div class="col-md-12">

                    <div class="form-group row">
                        <label class="col-xs-2 col-form-label">Receipt Number:</label>
                        <div class="col-xs-6">
                            <input type="text" id="sale" class="form-control">
                            <div id="data"></div>
                        </div>
                    </div>
                    <div id="result"></div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa fa-send-o"></i> Proceed
                </button>
            </div>
        </div>
    </form>

    @if(!$data['returns']->isEmpty())
    <div class="box-header with-border">
        <h3 class="box-title">Previous Item Returns</h3>
    </div>
    <div class="box-body">

        <div class="row">
            <div class="col-md-12">
                <table class="items table  table-striped table-condensed" id="tab_logic">
                    <thead>
                        <tr>
                            <th>Receipt Number</th>
                            <th>Product</th>
                            <th style="text-align:center">Quantity</th>
                            <th>Reason</th>
                            <th style="text-align:center">Credit Note</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['returns'] as $r)
                        <tr>
                            <td>{{$r->receipt_no}}</td>
                            <td>{{$r->products->name}}</td>
                            <td style="text-align:center">{{$r->quantity}}</td>
                            <td>{{$r->reason}}</td>
                            <td style="text-align:center">
                                <a target="blank" href="{{route('inventory.sales.cnote', $r->id)}}">
                                    <i class="fa fa-sticky-note" aria-hidden="true"></i>
                                </a>
                            </td>
                            <th>{{$r->created_at}}</th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>

<script type="text/javascript">
    function fillForm(receipt) {
        $(document).ready(function () {
            $.ajax({
                type: "get",
                url: "{{route('inventory.sales.fillreturnform')}}",
                data: {'rcpt': receipt},
                dataType: "html", //expect html to be returned
                success: function (response) {
                    $("#result").html(response);
                }
            });
        });
    }

    function scoop(rcpt) {
        $('#sale').val(rcpt);
        $('#data').hide();
        fillForm(rcpt);
    }

    $(document).ready(function () {
        $('#sale').keyup(function () {
            var q = this.value;
            $.ajax({
                type: 'get',
                url: "{{route('inventory.ajax.sales.sale.details')}}",
                data: {'key': q},
                dataType: 'html',
                success: function (response) {
                    $('#data').html(response);
                }
            });
        });
    });


</script>
@endsection