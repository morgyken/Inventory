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
?>

@extends('layouts.app')
@section('content_title','Invoice Details')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-body">
        <h4>Invoice Details</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Creditor</th>
                    <th>GL Account</th>
                    <th>Invoice Date</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$inv->number}}</td>
                    <td>{{$inv->creditors->name}}</td>
                    <td>{{$inv->gls->name}}</td>
                    <td>{{$inv->date}}</td>
                    <td>{{$inv->due_date}}</td>
                    <td>{{$inv->amount}}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6"><b>Description:</b><br/>{{$inv->description}}</td>
                </tr>
                <tr>
                    <td colspan="6"><b>Payment Status:</b><br/>
                        @if($inv->status=='unpaid')
                        <span class="label label-danger">
                            <i class="fa fa-cog fa-spin" aria-hidden="true"></i>
                            {{$inv->status}}
                        </span>
                        <span class="label label-info">
                            <i class="fa fa-money" aria-hidden="true"></i>
                            <a href="#" id="payment_toggle" data-toggle="collapse" data-target="#payment" style="color: whitesmoke">Add Payment</a></span>

                        <div id="payment" class="collapse">
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
                                                <input type="text" id="amount" readonly="" class="form-control" name="amount" value="{{$inv->amount}}">
                                                <div id="response"></div>
                                                <input type="hidden" name="invoice_id" value="{{$inv->id}}">
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
                        @else
                        <span class="label label-success">
                            <i class="fa fa-check" aria-hidden="true"></i>
                            {{$inv->status}}
                        </span>
                        @endif
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    var ACCOUNT_URL = "{{route('finance.ajax.widthraw.bogus')}}";
</script>
<script type="text/javascript" src="{!! Module::asset('inventory:js/check_account.js') !!}"></script>
@endsection