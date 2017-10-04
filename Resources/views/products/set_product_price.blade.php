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
extract($data);
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
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>How to adjust price!</strong> <br/>
                        <ol>
                            <li>Search for the product in table below</li>
                            <li>Select edit in the row</li>
                            <li>Click the save button below</li>
                        </ol>
                    </div>
                </div>
                <br/>
            </div>
            <div class="row">
                <div class="col-md-12">
                    @if(!$products->isEmpty())
                        <form method="post" id="myForm">
                            {!! Form::token() !!}
                            <table class="table table-striped" id="datatable">
                                <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item</th>
                                    <th>Cost Price</th>
                                    <th style="text-align: right">Cash Price</th>
                                    <th style="text-align: right">Insurance Price</th>
                                </tr>
                                </thead>
                                @foreach($products as $m)
                                    <tr>
                                        <td>{{$m->product_code}}</td>
                                        <td>{{$m->desc}}</td>
                                        <td>{{$m->batches->last()->unit_cost??0}}</td>
                                        <td style="text-align: right">
                                            <input type="text" name="cash{{$m->id}}"
                                                   pid="{{$m->id}}"
                                                   value="{{$m->selling_p}}"/>
                                        </td>
                                        <td style="text-align: right">
                                            <input type="text" name="insurance{{$m->id}}"
                                                   pid="{{$m->id}}"
                                                   value="{{$m->insurance_p}}"/>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <td>
                                <button type="button" class="btn btn-primary" id="save">
                                    Save
                                </button>
                            </td>
                        </form>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var data = [], arrIndex = {};

            function addOrReplace(object) {
                var index = arrIndex[object.product];
                if (index === undefined) {
                    index = data.length;
                    arrIndex[object.product] = index;
                }
                data[index] = object;
            }

            $('#datatable').dataTable();
            $('input[type=text]').keyup(function () {
                var product = $(this).attr('pid');
                var update = {
                    product: product,
                    cash: $('input[name=cash' + product + ']').val(),
                    insurance: $('input[name=insurance' + product + ']').val()
                };
                addOrReplace(update);
            });
            $('#save').click(function () {
                $.ajax({
                    url: "{{route('api.inventory.product.price.edit')}}",
                    method: 'POST',
                    data: {
                        _token: "{{csrf_token()}}",
                        data: data
                    },
                    dataType: "json",
                    success: function () {
                        alertify.success("Updates saved");
                        data = [];
                        arrIndex = {};
                    },
                    error: function () {
                        alertify.error("An error occurred");
                    }
                });
            });
        });
    </script>
@endsection
