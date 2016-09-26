
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
@section('content_title','Set Category Price')
@section('content_description','Manage Category Prices')

@section('content')
<div class="box box-info">
    <form class="form-horizontal" method="post" action="{{ route('inventory.category.save_price')}}">
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
                                <th style="width: 50%;">Category</th>
                                <th class="text-center" style="width: 20%;">Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id='addr0'>
                                <td></td>
                                <td>
                                    <select name="cats[]" class=" form-control" style="width: 100%">
                                        @foreach($data['product_categories'] as $cat)
                                        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name='prices[]' placeholder='Category Price ie 50.00'/></td>
                                <td>
                                    <a href="#" onclick="rowFade(addr0)" class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></a>
                                </td>
                            </tr>
                            <tr id='addr1'></tr>
                        </tbody>
                        <tfoot>

                            <tr>
                                <td><a id="add_row" @if(count($data['product_categories'])==1)disabled="true"@endif class="btn btn-primary btn-sm pull-left">
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
        <th>Category</th>
        <th><center>Price</center></th>
        <th></th>
        </thead>
        @foreach($data['price'] as $m)
        <tr>
            <td>{{$m->id}}</td>
            <td>{{$m->cats->name}}</td>
            <td><center>{{$m->price}}</center></td>
        <td>
            <a href="{{route('inventory.category.price.del', $m->id)}}"><i class="fa fa-trash"></i> Delete</a>
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
            var to_add = "<td></td> <td> <select name=\"cats[]\" class=\" form-control\" style=\"width: 100%\"> @foreach($data['product_categories'] as $cat) <option value=\"{{ $cat['id'] }}\">{{ $cat['name'] }}</option> @endforeach </select> </td> <td><input type=\"text\" name=\"prices[]\" placeholder=\"Category Price ie 50.00\"/></td> <td> <a href=\"#\" onclick=\"rowFade('addr" + i + "')\" class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></a> </td>";
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