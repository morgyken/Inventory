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
                    @if(!$data['price']->isEmpty())
                        <form method="post" action="{{route('inventory.product.price.edit')}}">
                            {!! Form::token() !!}
                            <table class="table table-striped" id="datatable">
                                <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Batch</th>
                                    <th>Item</th>
                                    <th style="text-align: center">Cash Price</th>
                                    <th style="text-align: center">Insurance Price</th>
                                    <th style="text-align: center">Edit</th>
                                    <th style="text-align: center">Delete</th>
                                </tr>
                                </thead>
                                @foreach($data['price'] as $m)
                                    @if(!empty($m->products))
                                        <tr>
                                            <td>{{$m->products->product_code}}</td>
                                            <td>{{$m->batch?$m->batch:''}}</td>
                                            <td>{{$m->products->desc}}</td>
                                            <td>
                                                <center>{{$m->cash_price}}</center>
                                            </td>
                                            <td>
                                                <center>{{$m->insurance_price}}</center>
                                            </td>
                                            <td style="text-align: center">
                                                <a href="#demo{{$m->id}}" data-toggle="collapse"><i
                                                            class="fa fa-pencil"></i></a>

                                                <div id="demo{{$m->id}}" class="collapse">
                                                    <input type="hidden" name="id[]" value="{{$m->id}}">
                                                    <input type="text" name="price[]" value="{{$m->price}}"
                                                           placeholder='New Price '/>
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
                                    <td></td>
                                    <td style="text-align: center">

                                    </td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> Save Changes
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#datatable').dataTable();
        });
    </script>
@endsection
