<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: KBravo<bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
$del = $data['del'];
$item = $data['items'];
?>

@extends('layouts.app')
@section('content_title','Batch Details')
@section('content_description','Goods received details')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Details </h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-striped">
                    <tbody>
                        <tr>
                            <td>{{$del->id}}</td>
                            <td>
                                @if($del->supplier>0)
                                {{$del->suppliers->name}}
                                @endif
                            </td>
                            <td>{{$del->users->username}}</td>
                            <td>{{$del->created_at}}</td>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
                            <th>Delivery</th>
                            <th>Supplier</th>
                            <th>Received By</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                </table>
            </div>


            <div class="box-header with-border">
                <h3 class="box-title">Item Details </h3>
            </div>


            <div class="col-md-12">
                <table class="table table-responsive table-striped" id="deliveries">
                    <tbody>
                        <?php $t = 0; ?>
                        @foreach($item as $i)
                        <?php $t+=$i->total; ?>
                        <tr>
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
                            <th colspan="6"></th>
                            <th>Total</th>
                            <th>{{number_format($t,2 )}}</th>
                        </tr>
                    </tbody>
                    <thead>
                        <tr>
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
                                @if($del->payment_status==0)
                                <span class="label label-danger">
                                    <i class="fa fa-cog fa-spin" aria-hidden="true"></i>
                                    Unpaid
                                </span>
                                <span class="label label-info">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <a href="#" id="payment_toggle" data-toggle="collapse" data-target="#payment" style="color: whitesmoke">
                                        Add <i class="fa fa-rub"></i>ayment</a>
                                </span>
                                @elseif($del->payment_status==2)
                                <span class="label label-warning">
                                    <i class="fa fa-hourglass fa-spin"></i>
                                    Partially Paid
                                </span>
                                <span class="label label-info">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <a href="#" id="payment_toggle" data-toggle="collapse" data-target="#payment" style="color: whitesmoke">
                                        Add <i class="fa fa-rub"></i>ayment</a>
                                </span>
                                @else
                                <span class="label label-success">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    Paid
                                </span>
                                @endif


                                <div id="payment" class="collapse">
                                    <form method="post" action="{{route('finance.gl.save.payment')}}">
                                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                                        <table class="table table-responsive table-striped">
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
                                                        <input type="text" id="amount" readonly="" autocomplete="off" class="form-control" name="amount" value="{{ceil($t)}}">
                                                        <div id="response"></div>
                                                        <input type="hidden" name="grn_id" value="{{$del->id}}">
                                                    </td>
                                                    <td>
                                                        {{$del->suppliers->name}}
                                                    </td>
                                                    <td></td>
                                                    <td><input type="submit" name="Proceed" value="Save Payment">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <thead>
                                                <tr>
                                                    <th>Payment Mode</th>
                                                    <th>Amount</th>
                                                    <th>Payment was made To</th>
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
</div>

<script>
    var ACCOUNT_URL = "{{route('finance.ajax.widthraw.bogus')}}";
</script>
<script type="text/javascript" src="{!! m_asset('inventory:js/check_account.js') !!}"></script>
@endsection