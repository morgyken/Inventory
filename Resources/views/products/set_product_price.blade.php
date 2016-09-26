
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

    <div class="box-header with-border">
        <h3 class="box-title">Select Product to Continue</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['route'=>'inventory.product.save_prod_price','class'=>'form-horizontal'])!!}
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
                                {!! Form::select('products[]',get_products(),null,['class'=>'form-control'])!!}
                            </td>
                            <td><input type="text" name="prices[]" placeholder='Price '/></td>
                            <td><a href="#"  class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                        <tr id="addr1"></tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><a id="add_row" class="btn btn-primary btn-sm pull-left">
                                    <i class="fa fa-plus"></i> Add products</a>
                            </td>
                            <td> <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-send-o"></i> Save
                                </button></td>
                            <td></td>

                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                {!! Form::close()!!}

            </div>
            <br/>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(!$data['price']->isEmpty())

                <form method="post" action="{{route('inventory.product.price.edit')}}">
                    {!! Form::token() !!}
                    <table class="table table-striped" id="datatable">
                        <thead>
                        <th>Product Code</th>
                        <th>Product</th>
                        <th style="text-align: center">Price</th>
                        <th style="text-align: center">Edit</th>
                        <th style="text-align: center">Delete</th>
                        </thead>
                        @foreach($data['price'] as $m)
                        @if(!empty($m->products))
                        <tr>
                            <td>{{$m->products->product_code}}</td>
                            <td>{{$m->products->name}}</td>
                            <td><center><?php echo ceil($m->price) ?></center></td>
                        <td style="text-align: center">
                            <a href="#demo{{$m->id}}" data-toggle="collapse"><i class="fa fa-pencil"></i></a>

                            <div id="demo{{$m->id}}" class="collapse">
                                <input type="hidden" name="id[]" value="{{$m->id}}">
                                <input type="text" name="price[]" value="{{$m->price}}" placeholder='New Price '/>
                            </div>
                        </td>
                        <td style="text-align: center">
                            <a href="{{route('inventory.product.price.del', $m->id)}}">
                                <i style="color: red" class="fa fa-trash"></i>
                            </a>
                        </td>
                        </tr>
                        @endif
                        @endforeach
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align: center">

                                    <button type="submit">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                    </button>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </form>
                @endif
            </div>
        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        var i = 1;
        $("#add_row").click(function () {
            var to_add = "<td></td><td><select name=\"products[]\" class=\"form-control\" style=\"width: 100%\">@foreach($data['products'] as $p)<option value=\"{{ $p['id'] }}\">{{ $p['name'] }}</option>@endforeach</select></td>  <td><input type=\"text\" name=\"prices[]\" placeholder=\"Price\"/></td>  <td><a href=\"#\" class=\"btn btn-xs btn-danger remove\"><i class=\"fa fa-trash-o\"></i></a></td> ";
            $('#addr' + i).html(to_add);
            $('#tab_logic').append('<tr id="addr' + (i + 1) + '"></tr>');
            i++;
        });
        $('body').on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });
    });
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
