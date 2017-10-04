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
                        <form method="post" action="{{route('inventory.product.price.edit')}}">
                            {!! Form::token() !!}
                            <table class="table table-striped" id="datatable">
                                <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item</th>
                                    <th>Cost Price</th>
                                    <th style="text-align: right">Cash Price</th>
                                    <th style="text-align: right">Insurance Price</th>
                                    <th style="text-align: center">Edit</th>
                                </tr>
                                </thead>
                                @foreach($products as $m)
                                    <tr>
                                        <td>{{$m->product_code}}</td>
                                        <td>{{$m->desc}}</td>
                                        <td>{{$m->batches->last()->unit_cost??0}}</td>
                                        <td style="text-align: right">
                                            <input type="text" name="cash{{$m->id}}"
                                                   pid="{{$m->id}}" ptp="cash"
                                                   value="{{$m->selling_p}}" class="item"/>
                                        </td>
                                        <td style="text-align: right">
                                            <input type="text" name="insurance{{$m->id}}"
                                                   pid="{{$m->id}}" ptp="insurance"
                                                   value="{{$m->insurance_p}}" class="item"/>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-xs edit" pid="{{$m->id}}">
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </form>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').dataTable({responsive: true});
            $('.edit').click(function () {
                var product = $(this).attr('pid');
                var data = {
                    cash: $('input[name=cash' + product + ']'),
                    insurance: $('input[name=insurance' + product + ']'),
                };
                console.log(data);
            });
        });
    </script>
@endsection
