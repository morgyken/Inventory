<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: KIPTOO BRAVO <bkiptoo@collabmed.com>
 *
 * =============================================================================
 */
?>

@extends('layouts.app')
@section('content_title','Stock Report')
@section('content_description','View detailed stock report')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">

    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['stocks']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['stocks'] as $s)
                        <tr id="category{{$s->id}}">
                            <td>{{$s->id}}</td>
                            <td>{{$s->products->name}}</td>
                            <td>{{$s->products->categories->name}}</td>
                            <td>{{$s->products->units->name}}</td>
                            @if($s->quantity<20)
                            <td style="color:red">{{$s->quantity ?$s->quantity :'0'}}</td>
                            @else
                            <td>{{$s->quantity ?$s->quantity: '0'}}</td>
                            @endif
                            <td>
                                <a href="{{route('inventory.adjust_stock',$s->products->id)}}"
                                   class="btn btn-primary btn-xs">
                                    <i class="fa fa-adjust"></i> Adjust
                                </a>
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