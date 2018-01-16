@extends('layouts.app')

@section('content_title', $store->name)
@section('content_description','Manage orders received')

@section('content')
    @include('inventory::store.orders.includes.dash', ['ordersMade' => $ordersMade, 'ordersReceived' => $ordersReceived])

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">View order requests</div>
                <div class="panel-body">
                    @if(!$ordersReceived->isEmpty())
                        <table class="table table-responsive table-striped">
                            <tbody>
                            @foreach($ordersReceived as $item)
                                <tr id="supplier{{$item->id}}">
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->users->profile->name}}</td>
                                    {{--<td>{{$item->disp_store->name}}</td>--}}
                                    <td>{{$item->rq_store->name}}</td>
                                    <td>{{$item->nice_status}}</td>
                                    <td>{{$item->created_at->format('d/m/Y')}}</td>
                                    <td>
                                        <a href="{{route('inventory.store.dispatch', $item->id)}}">
                                            <i class="fa fa-eye"></i> Dispatch
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                {{--<th>Dispatching Store</th>--}}
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
@endsection