<?php
/*
 * Collabmed Solutions Ltd
 * Project: iClinic
 *  Author: KIPTOO BRAVO <bkiptoo@collabmed.com>
 */
$records = $data['records'];
if (Illuminate\Support\Facades\Input::get('scope')) {
    $scope = Illuminate\Support\Facades\Input::get('scope');
} else {
    $scope = 'null';
}
$start = 'null';
$end = 'null';
$today = (new \DateTime())->format('Y-m-d');
?>

@extends('layouts.app')
@section('content_title','Expiry Report')
@section('content_description','View detailed report on item expiry dates')

@section('content')
<div class="box box-info">
    @if(!$data['records']->isEmpty())
    <div class="box-header">
        <i style="float: left">Filter by items expiring in the next 'n' months</i>
        <div class="pull-right">
            {!! Form::open()!!}
            Expiring in the next:<input type="number" name="scope" value="" placeholder="i.e 3"/>months
            <button  type="submit" id="clearBtn" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
            {!! Form::close()!!}

        </div>
    </div>
    <div class="box-body">
        <div class="alert alert-success">
            <i class="fa fa-info-circle"></i> {{filter_description($data['filter'])}}
        </div>
        <table id="cashier" class="table table-borderless">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Batch</th>
                    <th>Arrival Date</th>
                    <th>Units in Store</th>
                    <th>Expiry Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $n = 0; ?>
                @foreach($records as $record)
                <tr>
                    <td>{{$n+=1}}</td>
                    <td>{{$record->products->name}}
                        @if($record->products->strength)
                        {{$record->products->strength}} {{$record->products->units->name}}
                        @endif
                    </td>
                    <td>{{$record->batch}}</td>
                    <td>{{(new Date($record->created_at))->format('jS M Y')}}</td>
                    <td>{{$record->remaining}}</td>
                    <td>
                        {{(new Date($record->expiry_date))->format('jS M Y')}}
                    </td>
                    <td>
                        @if($record->expiry_date < $today)
                        <span style="color: red">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Expired
                            {{\Carbon\Carbon::createFromTimeStamp(strtotime($record->expiry_date))->diffForHumans() }}
                        </span>
                        @else
                        <span style="color: green"><i class="fa fa-circle-o-notch fa-spin"></i>
                            {{ \Carbon\Carbon::createFromTimeStamp(strtotime($record->expiry_date))->diffForHumans()}}
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">
        <p>No Expiry Date Records to show</p>
    </div>
    @endif
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#date1").datepicker({dateFormat: 'yy-mm-dd', onSelect: function (date) {
                $("#date2").datepicker('option', 'minDate', date);
            }});
        $("#date2").datepicker({dateFormat: 'yy-mm-dd'});

        $('#cashier').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });

    });
</script>
@endsection


