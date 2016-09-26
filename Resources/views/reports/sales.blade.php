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
            {!! Form::open()!!}
            Start Date: <input type="text" id="date1" name="start" value="{{$start}}"/>
            End Date: <input type="text" id="date2" name="end" value="{{$end}}"/>
            <button  type="submit" id="clearBtn" class="btn btn-primary btn-xs"><i class="fa fa-filter"></i> Filter</button>
            <a class="btn btn-xs btn-success" href="{{route('reports.cashier',['start'=>$start,'end'=>$end])}}"
               target="_blank"><i class="fa fa-file-pdf-o"></i> pdf</a>
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
                    <th>Receipt No.</th>
                    <th>Cashier</th>
                    <th>Amount</th>
                    <th>Mode</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cash_amnt = $cheq_amnt = $mpesa_amnt = $card_amnt = $insurance = 0;
                ?>
                @foreach($records as $record)
                <tr>
                    <td>{{$record->receipt}}</td>
                    <td>{{$record->users->profile->full_name}}</td>

                    @if($record->payment_mode=='cash')
                    <td>{{$record->amountpaid->CashAmount}}</td>

                    @elseif($record->payment_mode=='mpesa')
                    <td>{{$record->amountpaid->MpesaAmount}}</td>

                    @elseif($record->payment_mode=='cheque')
                    <td>{{$record->amountpaid->ChequeAmount}}</td>

                    @elseif($record->payment_mode=='card')
                    <td>{{$record->amountpaid->CardAmount}}</td>

                    @elseif($record->payment_mode=='insurance')
                    <td>{{$record->amountpaid->InsuranceAmount}}</td>
                    @endif

                    <td>{{$record->payment_mode}}</td>
                    <td>{{(new Date($record->created_at))->format('jS M Y')}}</td>
                </tr>
                <?php
                $cash_amnt += $record->amountpaid->CashAmount;
                $mpesa_amnt += $record->amountpaid->MpesaAmount;
                $cheq_amnt += $record->amountpaid->ChequeAmount;
                $card_amnt += $record->amountpaid->CardAmount;
                $insurance += $record->amountpaid->InsuranceAmount;
                ?>
                @endforeach
            </tbody>
        </table>
        <div>
            <hr/>
            <h4>Sales Summary</h4>
            <table class='table'>
                <tr><td>Cash:</td><td>{{number_format($cash_amnt,2)}}</td></tr>
                <tr><td>MPESA:</td><td>{{number_format($mpesa_amnt,2)}}</td></tr>
                <tr><td>Cheque:</td><td>{{number_format($cheq_amnt,2)}}</td></tr>
                <tr><td>Card:</td><td>{{number_format($card_amnt,2)}}</td></tr>
                <tr><td>Total Sales:</td><td>{{number_format($card_amnt+$cheq_amnt+$mpesa_amnt+$cash_amnt,2)}}</td></tr>
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
        $('#cashier').DataTable();
    });
</script>
@endsection


