<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>
@extends('layouts.app')
@section('content_title','Set Product Price')
@section('content_description','Manage Product Prices')

@section('content')
<div class="box box-info">
    <form class="form-horizontal" method="post" action="{{ route('inventory.product.save_prod_price')}}">
        {!! Form::open(['class'=>'form-horizontal']) !!}
        <div class="box-header with-border">
            <h3 class="box-title">Select Product to Continue</h3>
        </div>
        <div class="box-body">

            <div class="row">
                <div class="col-md-12">
                    <table class="items table  table-striped table-condensed" id="tab_logic">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width: 50%;">Product</th>
                                <th class="text-center" style="width: 20%;">Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id='addr0'>
                                <td></td>
                                <td>
                                    <input type='hidden' value='' name='products[]' id='product0'>
                                    <input id="item0" onkeyup="suggest(this.value, 0)" class="form-control" type="text">
                                    <div id="suggesstion-box0"></div>
                                </td>
                                <td><input type="text" name="prices[]" id="price0" placeholder='Item Price ie 50.00'/></td>
                                <td><a href="#" onclick="rowFade(addr0)" class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></a></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><a id="add_row" class="btn btn-primary btn-sm pull-left">
                                        <i class="fa fa-plus"></i> More</a>
                                </td>
                                <td></td>
                                <td></td>
                                <td><strong id="total"></strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa fa-send-o"></i> Save
                </button>
            </div>
        </div>
    </form>
    @if(!$data['price']->isEmpty())
    <table class="table table-striped" id="datatable">
        <thead>
        <th>#</th>
        <th>Product</th>
        <th><center>Price</center></th>
        <th></th>
        </thead>
        @foreach($data['price'] as $m)
        <tr>
            <td>{{$m->id}}</td>
            <td>{{$m->products->name}}{{$m->products->strength?'('.$m->products->strength. $m->products->units->name.')'}}</td>
            <td><center>{{$m->price}}</center></td>
        <td>
            <a href="{{route('inventory.product.price.del', $m->id)}}"><i class="fa fa-trash"></i> Delete</a>
        </td>
        </tr>
        @endforeach
    </table>
    <div class="box-footer"></div>
    @endif
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var i = 1;

        $("#add_row").click(function () {
            var to_add = "<td></td>  <td><input type='hidden' value='' name='products[]' id='product" + i + "'><input id=\'item" + i + "\' onkeyup=\'suggest(this.value," + i + ")\' class=\"form-control\" type=\"text\"><div id=\'suggesstion-box" + i + "\'></div></td>  <td><input id=\'price" + i + "\' type=\"text\" name=\"prices[]\" placeholder=\"Item Price ie 50.00\"/></td>  <td><a href=\"#\" onclick=\"rowFade('addr" + i + "')\" class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></a></td> ";
            $('#addr' + i).html(to_add);
            $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
            i++;
        });

    });

    function rowFade(div) {
        var div = document.getElementById(div);
        $(div).fadeOut(800, function () {
            div.html(result).fadeIn().delay(2000);
        });
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('#datatable').dataTable();
        } catch (e) {
        }
    });
</script>

<script>
    // AJAX call for autocomplete
    function suggest(search, row) {
        $(document).ready(function () {
            $.ajax({
                type: "get",
                url: "{{route('inventory.prod.tulus')}}",
                data: {i: row, key: search},
                beforeSend: function () {
                    $("#item" + row).css("background", "#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function (data) {
                    $("#suggesstion-box" + row).show();
                    $("#suggesstion-box" + row).html(data);
                    $("#item" + row).css("background", "#FFF");
                }
            });
        });
    }
    function setValue(item, price, i, id) {
        $("#item" + i).val(item);
        $("#product" + i).val(id);
        $("#price" + i).val(price);
        $("#suggesstion-box" + i).hide();
    }
</script>
@endsection
