
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
@section('content_title','Set Product Discount')
@section('content_description','Manage Product Discounts')

@section('content')
<div class="box box-info">
    <form class="form-horizontal" method="post" action="{{ route('inventory.product.save_discount')}}">
        {!! Form::open(['class'=>'form-horizontal']) !!}
        <div class="box-header with-border">
            <h3 class="box-title">Select Product(s) to Continue</h3>
        </div>
        <div class="box-body">

            <div class="row">
                <div class="col-md-12">
                    <table class="items table  table-striped table-condensed" id="tab_logic">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width: 50%;">Product</th>
                                <th class="text-center" style="width: 20%;">Discount(%)</th>
                                <th class="text-center" style="width: 20%;">End Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id='addr0'>
                                <td></td>
                                <td>
                                    <select name="products[]" class="form-control" style="width: 100%">
                                        @foreach($data['products'] as $p)
                                        <option value="{{ $p['id'] }}">{{ $p['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name='discounts[]' placeholder='Item Discount ie 4.5%'/></td>
                                <td>
                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                                        <div class="col-md-8">
                                            <input type="text" name="end_dates[]" class='form-control date'>
                                            {!! $errors->first('end_date', '<span class="help-block">:message</span>') !!}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" onclick="rowFade(addr0)" class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></a>
                                </td>
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
        @if(!$data['discount']->isEmpty())
        <table class="table table-striped">
            <thead>
            <th>#</th>
            <th>Product</th>
            <th><center>Discount(%)</center></th>
            <th><center>End Date</center></th>
            <th></th>
            </thead>
            @foreach($data['discount'] as $m)
            <tr>
                <td>{{$m->id}}</td>
                <td>{{$m->products->name}}</td>
                <td><center>{{$m->discount}}</center></td>
            <td><center>{{$m->end_date}}</center></td>
            <td>
                <a href="{{route('inventory.product.discount.del', $m->id)}}"><i class="fa fa-trash"></i> Delete</a>
            </td>
            </tr>
            @endforeach
        </table>
        <div class="box-footer"></div>
        @endif
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.date').datepicker({minDate: "0"});
        var i = 1;
        $("#add_row").click(function () {
            var to_add = "<td></td> <td> <select name=\"products[]\" class=\"form-control\" style=\"width: 100%\"> @foreach($data['products'] as $p) <option value=\"{{ $p['id'] }}\">{{ $p['name'] }}</option> @endforeach </select> </td> <td><input type=\"text\" name=\"discounts[]\" placeholder=\"Item Discount ie 4.5%\"/></td> <td> <div class=\"form-group {{ $errors->has('name') ? ' has-error' : '' }} req\"> <div class=\"col-md-8\"> <input type=\"text\" name=\"end_dates[]\" class=\"form-control date\"> {!! $errors->first('end_date', '<span class=\"help-block\">:message</span>') !!} </div> </div> </td> <td> <a href=\"#\" onclick=\"rowFade('addr" + i + "')\" class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></a> </td>";
            $('#addr' + i).html(to_add);
            $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
            i++;
        });

    });

    $(function () {
        $("#datepicker").datepicker();
    });


    function rowFade(div) {
        var div = document.getElementById(div);
        $(div).fadeOut(800, function () {
            div.html(result).fadeIn().delay(2000);
        });
    }
</script>
@endsection
