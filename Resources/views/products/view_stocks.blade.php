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
@section('content_title','Stock')
@section('content_description','View products in store')

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
                            <td>{{$product->product_code}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->categories?$product->categories->name:'-'}}</td>
                            <td>{{$product->units?$product->units->name:'-'}}</td>
                            <td>{{$product->stocks?$product->stocks->quantity : '0'}}</td>
                            <td>
                                <a href="{{route('inventory.adjust_stock',$product->id)}}"
                                   class="btn btn-primary btn-xs">
                                    <i class="fa fa-adjust"></i> Adjust</a> <!--|
                                <button class="btn btn-danger btn-xs delete" value="{{$product->id}}">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th></th>
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
    });
</script>
@endsection