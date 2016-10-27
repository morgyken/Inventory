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
@section('content_title','Goods Received')
@section('content_description','Goods Received Note (GRN)')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">
            @if(!empty($data['batch']))
            <a href="{{route('inventory.dnote',$data['batch'])}}" target="blank" class="btn btn-sm btn-primary">
                <i class="fa fa-print"></i> Goods Received Note (GRN)
            </a>
            @endif
        </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-striped" >
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Package Size</th>
                            <th>Unit Cost</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sum = 0;
                        ?>
                        @foreach($data['bought'] as $item)
                        <tr>
                            <td>{{$item->products->name}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->package_size}}</td>
                            <td>{{number_format($item->unit_cost,2)}}</td>
                            <td>{{number_format($item->discount,2)}}%</td>
                            <td>{{number_format($item->tax,2)}}%</td>
                            <td>{{number_format($item->total,2)}}</td>
                        </tr>
                        <?php
                        $sum+=$item->total;
                        ?>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6">Total</th>
                            <th>{{number_format($sum,2 )}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection