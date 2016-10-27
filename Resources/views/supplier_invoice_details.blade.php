<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: KIPTOO BRAVO <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */

$inv = $data['inv'];
$batch = $data['batch'];
$n = 0;
?>

@extends('layouts.app')
@section('content_title','Invoice Details')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-body">
        <div class="col-md-12">
            <h4>Invoice Details</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Creditor</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$inv->number}}</td>
                        <td>{{$inv->creditors->name}}</td>
                        <td>{{$inv->date}}</td>
                        <td>{{$inv->due_date}}</td>
                        <td>{{$inv->amount}}</td>
                    </tr>
                    <tr>
                        <td colspan="7"><b>Description:</b><br/>{{$inv->description}}</td>
                    </tr>
                </tbody>
            </table>


        </div>
        <div class="col-md-6">
            <h4>Prior payments for this invoice</h4>
            @if(!$data['payments']->isEmpty())
            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
                @foreach($data['payments'] as $p)
                <tr>
                    <td>{{$n+=1}}</td>
                    <td>{{number_format($p->amount,2)}}</td>
                    <td>{{smart_date($p->created_at)}}</td>
                </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td style="text-align: right; font-weight: bolder">Total:</td>
                    <td><b>{{number_format($data['amount_paid'],2)}}</b></td>
                </tr>
                @if($inv->amount <$data['amount_paid'])
                <tr class="info">
                    <td style="text-align: right; font-weight: bolder" colspan="2">Excess Amount Paid!!:</td>
                    <td>{{number_format($data['amount_paid']-$inv->amount,2)}}</td>
                </tr>
                @endif
            </table>
            @else

            <table class="table">
                <tr class="info">
                    <td>NO payment has been made for this invoice yet</td>
                </tr>
            </table>
            @endif
        </div>
        <div class="col-md-6">
            <h4>Delivery Details</h4>
            <table class="table table-striped">
                <tr>
                    <th>GRN Number</th>
                    <th>Delivery Date</th>
                </tr>
                <tr>
                    <td>{{$inv->grns->id}}</td>
                    <td>{{smart_date($inv->grns->created_at)}}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-12">
            <h4>Purchase Details</h4>
            <table class="table table-responsive table-striped" id="deliveries">
                <tbody>
                    <?php $t = $n = 0; ?>
                    @foreach($data['items'] as $i)
                    <?php $t+=$i->total; ?>
                    <tr>
                        <td>{{$n+=1}}</td>
                        <td>{{$i->products->name}}</td>
                        <td>{{$i->package_size}}</td>
                        <td>{{$i->quantity}}</td>
                        <td>{{$i->bonus}}</td>

                        <td>{{$i->unit_cost}}</td>
                        <td>{{$i->discount}}</td>
                        <td>
                            @if($i->expiry_date == '0000-00-00')
                            not set
                            @else
                            {{$i->expiry_date}}
                            @endif
                        </td>
                        <td>{{number_format($i->total,2)}}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="7"></th>
                        <th>Total</th>
                        <th>{{number_format($t,2 )}}</th>
                    </tr>
                </tbody>
                </tbody>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Package Size</th>
                        <th>Quantity</th>
                        <th>Bonus</th>
                        <th>Unit Cost</th>
                        <th>Discount (%)</th>
                        <th>Expiry</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td colspan="8"><b>Payment Status:</b><br/>
                            @if($inv->status=='unpaid'||$inv->status==null)
                            <button class="btn btn-danger btn-sm" type="button" aria-expanded="false" aria-controls="collapseExample">
                                Unpaid
                            </button>
                            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#pay"
                                    aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-money" aria-hidden="true"></i>Add Payment
                            </button>
                            @elseif($inv->status=='partially paid')
                            <button class="btn btn-warning btn-sm" type="button" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-hourglass" aria-hidden="true"></i>Partially Paid
                            </button>
                            <a class="btn">Balance: {{$inv->amount-$data['amount_paid']}}</a>
                            <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#pay"
                                    aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-money" aria-hidden="true"></i>Add Payment
                            </button>
                            @else
                            <span class="label label-success">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                Settled
                            </span>
                            @endif
                            <div id="pay" class="collapse">
                                <form method="post" action="{{route('finance.gl.save.payment')}}">
                                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                    <table class="table table-responsive">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select required="" id="acc" name="payment_mode" class="form-control">
                                                        <option value=""></option>
                                                        <option value="petty">Petty Cash</option>
                                                        <option value="account"> Bank Account</option>
                                                    </select>
                                                    <br>
                                                    <div id="account">
                                                        <select id="accnt" name="account" class="form-control">
                                                            @foreach($data['accounts'] as $acc)
                                                            <option value="{{$acc->id}}">{{$acc->number}}</option>
                                                            @endforeach
                                                        </select>
                                                        <br>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" id="amount" class="form-control" name="amount" value="{{$inv->amount}}">
                                                    <div id="response"></div>
                                                    <input type="hidden" name="invoice_id" value="{{$inv->id}}">
                                                    <input type="hidden" name="inv_grn" value="{{$inv->grns->id}}">
                                                    <input type="hidden" name="grn_amount" value="{{$t}}">
                                                    <input type="hidden" name="due_amount" value="{{$inv->amount-$data['amount_paid']}}">
                                                    <input type="hidden" name="paid_amount" value="{{$data['amount_paid']}}">
                                                    <input type="hidden" name="inv_amount" value="{{$inv->amount}}">
                                                </td>
                                                <td></td>
                                                <td><input type="submit" name="Proceed" value="proceed">
                                                </td>
                                            </tr>
                                        </tbody>
                                        <thead>
                                            <tr>
                                                <th>Payment Mode</th>
                                                <th>Amount</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </form>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    var ACCOUNT_URL = "{{route('api.finance.widthraw.bogus')}}";
</script>
<script type="text/javascript" src="{!! m_asset('inventory:js/check_account.js') !!}"></script>
@endsection