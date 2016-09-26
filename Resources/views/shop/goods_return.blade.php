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
<div class="box box-info">
    <form class="form-horizontal" method="post" action="{{ route('inventory.sales.return')}}">
        {!! Form::open(['class'=>'form-horizontal']) !!}
        <div class="box-header with-border">
            <h3 class="box-title">Return Items</h3>
        </div>
        <div class="box-body">

            <div class="row">
                <div class="col-md-12">
                    <table class="items table table-condensed" id="tab_logic">
                        <thead>
                            <tr>
                                <th>Receipt Number</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select name="rcpt" id="rcpt" class=" form-control" onclick="fillForm(this.value)">
                                        @foreach($data['batch_sales'] as $b)
                                        <option value="{{ $b->receipt }}">{{ $b->receipt }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="items table table-condensed" id="tab_logic">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Reason</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="result"></tr>
                        </tbody>
                    </table>

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


    <div class="box-header with-border">
        <h3 class="box-title">Previous Item Returns</h3>
    </div>
    <div class="box-body">

        <div class="row">
            <div class="col-md-12">
                <table class="items table  table-striped table-condensed" id="tab_logic">
                    @if(!$data['returns']->isEmpty())
                    <thead>
                        <tr>
                            <th>Receipt Number</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Reason</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['returns'] as $r)
                        <tr>
                            <td>{{$r->receipt_no}}</td>
                            <td>{{$r->products->name}}</td>
                            <td>{{$r->quantity}}</td>
                            <td>{{$r->reason}}</td>
                            <th>{{$r->created_at}}</th>
                        </tr>
                        @endforeach
                    </tbody>
                    @else
                    No Items have been returned so far....
                    @endif
                </table>

            </div>
        </div>


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

    function fetchQtySold(product) {
        $(document).ready(function () {
            var receipt = $("#rcpt").val();
            //var receipt = rcpt.options[rcpt.selectedIndex].value;
            $.ajax({
                type: "get",
                url: "{{route('inventory.sales.qtysold')}}",
                data: {'product_id': product, 'rcpt': receipt},
                //dataType: "html", //expect html to be returned
                success: function (response) {
                    $("#response").html(response);
                }
            });
        });
    }
</script>
@endsection