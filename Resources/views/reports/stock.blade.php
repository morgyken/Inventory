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
        <h3 class="box-title">Item Stock Report</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['stocks']->isEmpty())
                <table class="table table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Code</th>
                            <th>Item</th>
                            <th>Cost</th>
                            <th>Remaining Stock Items</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $n = 0;
                        $total_value = 0;
                        $sell_value = 0;
                        ?>
                        @foreach($data['stocks'] as $s)
                        <?php
                        $price = $s->products->prices->max('price');
                        $value = $price * $s->quantity;
                        $total_value+=$value;
                        ?>
                        <tr id="category{{$s->id}}">
                            <td>{{$n+=1}}</td>
                            <td>{{$s->products->id}}</td>
                            <td>{{$s->products->name}}</td>
                            <td>{{number_format($price,2)}}</td>
                            @if($s->quantity<20)
                            <td style="color:red">{{$s->quantity ?$s->quantity :'0'}}</td>
                            @else
                            <td>{{$s->quantity ?$s->quantity: '0'}}</td>
                            @endif
                            <td>{{number_format($value,2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4"></th>
                            <th style="text-align: right">Total Stock Value:</th>
                            <th>{{number_format($total_value,2)}}</th>
                        </tr>
                    </tfoot>
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
            $('table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
        } catch (e) {
        }
    });
</script>
@endsection