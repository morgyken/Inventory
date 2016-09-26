<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: KIPTOO BRAVO <bkiptoo@collabmed.com>
 */
$records = $data['records'];
?>

@extends('layouts.app')
@section('content_title','Payments Overview (Receipts)')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-body">
        <table id="payments" class="table table-borderless">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Receipt No.</th>
                    <th>Cashier</th>
                    <th>Amount</th>
                    <th>Payment Mode</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $n = 0;
                $cash_amnt = $cheq_amnt = $mpesa_amnt = $card_amnt = $insurance = 0;
                ?>
                @foreach($records as $record)
                <?php $n+=1; ?>
                <tr>
                    <td>{{$n}}</td>
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

                    <td>

                        @if($record->payment_mode=='insurance')
                        <a href="{{route('inventory.sale.invoice.print',$record->id)}}" target="_blank">
                            <i class="fa fa-print"></i>
                        </a>
                        @else
                        <a href="{{route('inventory.sale.receipt.print',$record->id)}}" target="_blank">
                            <i class="fa fa-print"></i></a>
                        @endif
                    </td>
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
            <h4>Payments Summary</h4>
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
        try {
            $('#payments').dataTable();
        } catch (e) {
        }
    });
</script>
@endsection