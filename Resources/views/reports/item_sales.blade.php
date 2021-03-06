<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: KIPTOO BRAVO <bkiptoo@collabmed.com>
 */
$records = $data['records'];
$start = Illuminate\Support\Facades\Input::get('start');
$end = Illuminate\Support\Facades\Input::get('end');
$n = $total = $amount = 0;

function amount_after_discount($discount, $amount) {
    try {
        $discounted = $amount - (($discount / 100) * $amount);
        return $discounted;
    } catch (\Exception $e) {
        return $amount;
    }
}
?>

@extends('layouts.app')
@section('content_title','Item Sale Report')
@section('content_description','View detailed report of sales per item')

@section('content')
<div class="box box-info">
    <div class="box-header">
        <div class="pull-right">
            {!! Form::open()!!}
            From: <input type="text" id="date1" name="start" value="{{$start}}"/>
            To: <input type="text" id="date2" name="end" value="{{$end}}"/>
            <button  type="submit" id="clearBtn" class="btn btn-primary">
                <i class="fa fa-filter"></i> Filter
            </button>
            {!! Form::close()!!}

        </div>
    </div>
    <div class="box-body">
        <div class="alert alert-success">
            <i class="fa fa-info-circle"></i> {{filter_description($data['filter'])}}
        </div>
        <table id="cashier" class="table table-borderless">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th style="text-align: center">Quantity</th>
                    <th style="text-align: center">Price</th>
                    <th style="text-align: center">Discount(%)</th>
                    <th style="text-align: center">Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                <?php
                $total = $record->price * $record->quantity;
                $amount+=amount_after_discount($record->discount, $total);
                ?>
                <tr>
                    <td>{{$n+=1}}</td>
                    <td>{{$record->products->name}}{{$record->products->strength?'('.$record->products->strength.$record->products->units->name.')':''}}</td>
                    <td style="text-align: center">{{$record->quantity}}</td>
                    <td style="text-align: center">{{$record->price}}</td>
                    <td style="text-align: center">{{$record->discount}}</td>
                    <th style="text-align: center">{{number_format(amount_after_discount($record->discount, $total),2)}}</th>
                    <td>{{(new Date($record->created_at))->format('jS M Y')}}</td>
                </tr>
                @endforeach
                <tr>
                    <td>{{$n+=1}}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><strong>Total:</strong></td>
                    <td style="text-align: center"><strong>{{number_format($amount,2)}}</strong></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#date1").datepicker({dateFormat: 'yy-mm-dd', onSelect: function (date) {
                $("#date2").datepicker('option', 'minDate', date);
            }});
        $("#date2").datepicker({dateFormat: 'yy-mm-dd'});

        $('#cashier').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>
@endsection


