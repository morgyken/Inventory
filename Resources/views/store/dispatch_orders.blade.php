<?php
extract($data);
?>

@extends('layouts.app')

@section('content_title','Dispatch Orders')
@section('content_description','Dispatch Orders')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><a class="btn btn-primary btn-xs" href="{{route('inventory.store.new_order')}}">
                    <i class="fa fa-plus-square"></i> New Internal Order
                </a>
            </h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    @if(!$orders->isEmpty())
                        <table class="table table-responsive table-striped">
                            <tbody>
                            @foreach($orders as $item)
                                <tr id="supplier{{$item->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->users->profile->name}}</td>
                                    <td>{{$item->disp_store->name}}</td>
                                    <td>{{$item->rq_store->name}}</td>
                                    <td>{{$item->nice_status}}</td>
                                    <td>{{$item->created_at->format('d/m/Y')}}</td>
                                    <td><a href="{{route('inventory.store.dispatch',$item->id)}}">
                                            <i class="fa fa-eye"></i> View
                                        </a></td>
                                </tr>
                            @endforeach
                            </tbody>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Dispatching Store</th>
                                <th>Requesting Store</th>
                                <th>Status</th>
                                <th>Ordered Date</th>
                                <td>View</td>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <p>No records to show</p>
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
                        'excel', 'pdf', 'print'
                    ]
                });
            } catch (e) {
            }
        });
    </script>
@endsection