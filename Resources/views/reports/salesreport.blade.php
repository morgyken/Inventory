<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: KIPTOO BRAVO <bkiptoo@collabmed.com>
 */
$records = $data['records'];
$start = Illuminate\Support\Facades\Input::get('start');
$end = Illuminate\Support\Facades\Input::get('end');
?>

@extends('layouts.app')
@section('content_title','Sales Report')
@section('content_description','View detailed report of sales per time period')

@section('content')
<div class="box box-info">
    <div class="box-header">
        <div class="pull-right">
            <form method="post" action="{{route('analytics.inventory.sales')}}">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                From: <input type="text" id="date1" name="start" value="{{$start}}"/>
                To: <input type="text" id="date2" name="end" value="{{$end}}"/>
                <button  type="submit" id="clearBtn" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
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
                    <th>Receipt No.</th>
                    <th>Cashier</th>
                    <th>Amount</th>
                    <th>Mode(S)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cash_amnt = $cheq_amnt = $mpesa_amnt = $card_amnt = $insurance = 0;
                ?>
                @foreach($records as $record)
                <?php
                if (isset($record->payment)) {
                    $cash_amnt+=$record->payment->cash ? $record->payment->cash->amount : 0;
                    $cheq_amnt+=$record->payment->cheque ? $record->payment->cheque->amount : 0;
                    $mpesa_amnt+=$record->payment->mpesa ? $record->payment->mpesa->amount : 0;
                    $card_amnt+=$record->payment->card ? $record->payment->card->amount : 0;
                }
                ?>
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$record->payment?$record->payment->receipt:''}}</td>
                    <td>{{$record->payment->users->profile->full_name}}</td>
                    <td>{{$record->payment?$record->payment->amount:''}}</td>
                    <td>{{$record->payment?$record->payment->modes:''}}</td>
                    <td>{{(new Date($record->created_at))->format('jS M Y')}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <hr/>
            <h4>Sales Summary</h4>
            <table class='table'>
                <tr><td>Cash:</td><td style="text-align: left">{{number_format($cash_amnt,2)}}</td></tr>
                <tr><td>MPESA:</td><td style="text-align: left">{{number_format($mpesa_amnt,2)}}</td></tr>
                <tr><td>Cheque:</td><td style="text-align: left">{{number_format($cheq_amnt,2)}}</td></tr>
                <tr><td>Card:</td><td style="text-align: left">{{number_format($card_amnt,2)}}</td></tr>
                <tr><td>Total Sales:</td><td style="text-align: left">{{number_format($card_amnt+$cheq_amnt+$mpesa_amnt+$cash_amnt,2)}}</td></tr>
            </table>
        </div>
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


