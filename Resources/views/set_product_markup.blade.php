
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
@section('content_title','Set Product Markup Percentage')
@section('content_description','Manage Product Markup Percentages')

@section('content')
<div class="box box-info">
    <form class="form-horizontal" method="post" action="{{ route('inventory.product.markup')}}">
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
                                <th class="text-center" style="width: 20%;">Markup Percentage (%)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id='addr0'>
                                <td></td>
                                <td>
                                    <select name="product[]" class=" form-control" style="width: 100%">
                                        @foreach($data['products'] as $p)
                                        <option value="{{ $p['id'] }}">{{ $p['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name="markup[]" placeholder='Markup percentage ie 12 %'/></td>
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
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-send-o"></i> Save
                            </button>
                        </div>
                    </div>

                    <table class="table table-striped" id="datatable">
                        <thead>
                        <th>#</th>
                        <th>Product</th>
                        <th>Markup Percentage</th>
                        <th></th>
                        </thead>
                        @foreach($data['markup'] as $m)
                        <tr>
                            <td>{{$m->id}}</td>
                            <td>{{$m->products->name}}</td>
                            <td>{{$m->markup}}</td>
                            <td><a href="{{route('inventory.product.markup.del', $m->id)}}">&times</a></td>
                        </tr>
                        @endforeach
                    </table>

                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var i = 1;

        $("#add_row").click(function () {
            var to_add = "<td></td>  <td><select name=\"product[]\" class=\"form-control\" style=\"width: 100%\">@foreach($data['products'] as $p)<option value=\"{{ $p['id'] }}\">{{ $p['name'] }}</option>@endforeach</select></td>  <td><input type=\"text\" name=\"markup[]\" placeholder=\"Markup percentage ie 15%\"/></td>  <td><a href=\"#\" onclick=\"rowFade('addr" + i + "')\" class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></a></td> ";
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
@endsection
