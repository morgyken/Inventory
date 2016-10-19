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
@section('content_title','Point of sale(Credit)')
@section('content_description','Add items to cart')
@section('content')
<div class="box box-info">
    <div class="box-header">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation">
                <a href="{{route('inventory.shopfront')}}">
                    Direct Payment
                </a>
            </li>
            <li role="presentation" class="active">
                <a href="#credit" aria-controls="profile" role="tab" data-toggle="tab">
                    Insurance (Credit)
                </a>
            </li>
        </ul>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="direct">
                        {!! Form::open(['class'=>'form-horizontal', 'route'=>'inventory.shopfront.credit']) !!}
                        @include('inventory::shop.insurance_payment')
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
                                <tr>
                                    <td colspan="3"></td>
                                    <td>Total Cost: <strong id="sum"></strong></td>
                                    <td>Discount: <strong id="discount"></strong></td>
                                    <td>Net amount: <strong id="net" class="text-success"></strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td style="text-align: right"><label class="control-label col-md-4">Amount</label></td>
                                    <td colspan="2">
                                        <input name="amount" type="text" id="amnt" class="form-control" required/>
                                    </td>
                                </tr>

                            </tfoot>
                        </table>

                        <div class="pull-right">
                            <button type="submit" id="save" class="btn btn-success">
                                <i class="fa fa-send"></i> Bill
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div><!--End of Direct-->
                </div><!--End of tab content -->
            </div>
        </div>

    </div>
</div>
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
    var INSURANCE = true;
    var STOCK_URL = "{{route('inventory.ajax.getstock')}}";
    var PRODUCTS_URL = "{{route('inventory.ajax.get.products')}}";
    var SCHEMES_URL = "{{route('ajax.get_schemes')}}";
    var PHONE_URL = "{{route('inventory.ajax.cust.get')}}";
    var CREDIT_URL = "{{route('inventory.ajax.credit.rate')}}";
</script>
<script src="{!! m_asset('inventory:js/shopfront.js') !!}"></script>
@endsection