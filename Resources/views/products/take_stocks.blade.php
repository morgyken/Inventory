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
@section('content_title','Stock Take')
@section('content_description','Stock Taking')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">

        </div>

        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    @if(!$data['products']->isEmpty())
                        <table class="table table-responsive table-striped">
                            <tbody>
                            @foreach($data['products'] as $product)
                                <tr id="category{{$product->id}}">
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->categories?$product->categories->name:'-'}}</td>
                                    <td>{{$product->units?$product->units->name:'-'}}</td>
                                    <td>
                                        <input type="text" name="stock{{$product->id}}"
                                               stock="{{$product->stocks?$product->stocks->quantity : '0'}}"
                                               product="{{$product->id}}"
                                               value="{{$product->stocks?$product->stocks->quantity : '0'}}"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <p>No products</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>


    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            try {
                $('table').dataTable();
            } catch (e) {
            }
            $('input[type=text]').blur(function () {
                var data = {
                    id: $(this).attr('product'),
                    old_stock: parseInt($(this).attr('stock')),
                    quantity: parseInt($(this).val()),
                    reason: 'Stock take',
                    _token: "{{csrf_token()}}"
                };
                if (data.quantity !== data.old_stock) {
                    $.ajax({
                        type: 'post',
                        url: "{{route('inventory.adjust_stock.do','mine')}}",
                        data: data,
                        dataType: 'json'
                    });
                }
            });
        });
    </script>
@endsection