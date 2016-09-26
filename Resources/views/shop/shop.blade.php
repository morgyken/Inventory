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
@section('content_title','Point of sale')
@section('content_description','Point of sale ')

@section('content')
<div class="box box-info">
    {!! Form::open(['class'=>'form-horizontal']) !!}
    <div class="box-header with-border">
        <h3 class="box-title">Add items to cart</h3>
    </div>
    <div class="box-body">
        <div class="row">
            @include('inventory::shop.payments')
            <div class="col-md-12">

                <table class="items table  table-striped table-condensed" id="tab_logic">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Item</th>
                            <th class="text-center" style="width: 10%;">Quantity</th>
                            <th class="text-center" style="width: 10%;">Original Price</th>
                            <th class="text-center" style="width: 20%;">Selling Price</th>
                            <th style="width: 2%;">Discount (%)</th>
                            <th style="width: 12%;">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id='addr0'>
                            <td><select name="item0"   id="item_0" class="select2-single" style="width: 100%" required=""></select></td>
                            <td>
                                <input type="text" id="item_qty_0" autocomplete="off"  name='qty0' placeholder='Quantity' value="0"
                                       class="quantities"/>
                                <input type="hidden" name="batch0">
                                <span id="fb0"></span>
                            </td>
                            <td><span id="original0">-</span></td>
                            <td><input type="text" id="item_price_0" name='price0' placeholder='Price'/></td>
                            <td><input type="text" name='dis0' placeholder='Discount' value="0"/></td>
                            <td><span id="total0">0.00</span></td>
                            <td>
                                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                        <tr id='addr1'>
                            <td><select name="item1"   id="item_1" class=" select2-single" style="width: 100%"></select></td>
                            <td>
                                <input type="text"  name='qty1' id="item_qty_1" autocomplete="off"  placeholder='Quantity' value="0"
                                       class="quantities"/>
                                <input type="hidden" name="batch1">
                                <span id="fb1"></span>
                            </td>
                            <td><span id="original1">-</span></td>
                            <td><input type="text" name='price1' placeholder='Price'/></td>
                            <td><input type="text" name='dis1' placeholder='Discount' value="0"/></td>
                            <td><span id="total1">0.00</span></td>
                            <td>
                                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
                            </td>
                        </tr>
                        <tr id='addr2'>
                            <td><select name="item2"  id="item_2" class=" select2-single" style="width: 100%"></select></td>
                            <td>
                                <input type="text" name='qty2' id="item_qty_2" autocomplete="off"  placeholder='Quantity' value="0" class="quantities"/>
                                <span id="fb2"></span>
                                <input type="hidden" name="batch2">
                            </td>
                            <td><span id="original2">-</span></td>
                            <td><input type="text" name='price2' placeholder='Price'/></td>
                            <td><input type="text" name='dis2' placeholder='Discount' value="0"/></td>
                            <td><span id="total2">0.00</span></td>
                            <td>
                                <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
                            </td>

                        </tr>
                        <tr id='addr3'></tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <a id="add_row" class="btn btn-primary btn-sm pull-left">
                                    <i class="fa fa-plus"></i>
                                    Add</a>
                            </td>
                            <td colspan="4"></td>
                            <td><strong id="total">0.00</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <table class="table" id="customer">
                    <tr>
                        <td>
                            <i class="fa fa-user-plus"></i> Customer Info <b>(Optional)</b>
                        </td>
                        <td>
                            <input type="text" placeholder="Phone Number" value="" id="phone" name="phone" autocomplete="off" class="form-control"/>
                            <div id="suggesstion-box"></div>
                        </td>
                        <td><input type="text" id="fname" value="" placeholder="First Name" name="first_name" autocomplete="off" class="form-control"></td>
                        <td><input type="text" id="lname" value="" placeholder="Last Name" name="last_name" autocomplete="off" class="form-control"></td>
                        <td><input type="email" id="email" value="" placeholder="Email Address" autocomplete="off" name="email" class="form-control"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                    <dt>Total Cost</dt>
                    <dd><strong id="sum"></strong></dd></td>
                    <td>
                    <dt>Discount</dt>
                    <dd><strong id="discount"></strong></dd></td>
                    <td>
                    <dt>Net amount</dt>
                    <dd><strong id="net" class="text-success"></strong></dd>
                    </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><label class="control-label col-md-4">Amount</label></td>
                        <td>
                            <input name="amount" type="text" id="amnt" class="form-control" required/>
                        </td>
                    </tr>
                </table>

                <div class="pull-right">
                    <button type="submit" id="save" class="btn btn-success">
                        <i class="fa fa-send"></i> Complete
                    </button>
                </div>


            </div>
        </div>

    </div>
</div>
{!! Form::close() !!}
</div>

<script>
    // AJAX call for autocomplete
    $(document).ready(function () {
        var scheme_id = 0;
        $('#scheme').change(function () {
            scheme_id = $(this).val();
            console.log(scheme_id);
        });
    });
    var INSURANCE = false;
    var STOCK_URL = "{{route('inventory.ajax.getstock')}}";
    var PRODUCTS_URL = "{{route('inventory.ajax.get.products')}}";
    var SCHEMES_URL = "{{route('ajax.get_schemes')}}";
    var PHONE_URL = "{{route('inventory.ajax.cust.get')}}";
    var CREDIT_URL = "{{route('inventory.ajax.credit.rate')}}";
</script>
<script src="{!! Module::asset('inventory:js/shopfront.js') !!}"></script>
@endsection