<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo (bkiptoo@gmail.com)
 *
 * =============================================================================
 */
$count = 0;
?>
@extends('layouts.app')
@section('content_title','Goods Received Notes')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">GRNs </h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['deliveries']->isEmpty())
                <table class="table table-responsive table-striped" id="deliveries">
                    <tbody>
                        @foreach($data['deliveries'] as $del)
                        <tr>
                            <td>{{$del->id}}</td>
                            <td>
                                @if($del->supplier>0)
                                {{$del->suppliers->name}}
                                @endif
                            </td>
                            <td>{{$del->users->username}}</td>
                            <td>{{$del->created_at}}</td>
                            <td style="text-align: center">
                                <?php
                                if ($del->payment_status === 1) {
                                    echo '<i class="fa fa-check"></i>';
                                } else {
                                    echo '<i class="fa fa-cog fa-spin"></i>pending';
                                }
                                ?>
                            </td>
                            <td>
                                <a href="{{route('inventory.batch.details', $del->id)}}"> <i class="fa fa-plus-square-o">details</i></a>

                            </td>
                            <td>
                                @if(empty($del->order))
                                <a href="{{route('inventory.dnote',$del->id)}}" target="blank">
                                    <i class="fa fa-file-pdf-o"></i>
                                </a>
                                @else
                                <a href="{{route('inventory.dnote_lpo',$del->order)}}" target="blank">
                                    <i class="fa fa-file-pdf-o"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>Delivery</th>
                            <th>Supplier</th>
                            <th>Received By</th>
                            <th>Date</th>
                            <th style="text-align: center">Payment Status</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No Deliveries Yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('select').select2();
    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        try {
            $('#deliveries').dataTable();
        } catch (e) {
        }
    });
</script>
@endsection