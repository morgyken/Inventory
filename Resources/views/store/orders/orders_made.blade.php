@extends('layouts.app')

@section('content_title', $store->name)
@section('content_description','Manage orders made')

@section('content')
    @include('inventory::store.orders.includes.dash', $ordersMade)

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">Submit Order Form</div>
                <div class="panel-body">

                    {!! Form::open(['class'=>'form-horizontal','route'=>['inventory.store.orders.save']]) !!}

                        {!! Form::hidden('requesting_store', $store->id) !!}

                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('store') ? ' has-error' : '' }} req">
                                {!! Form::label('dispatching_store', 'Dispatching Store',['class'=>'col-md-4']) !!}

                                <div class="col-md-8">
                                    {!! Form::select('dispatching_store', $stores, null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('deliver_date') ? ' has-error' : '' }} req">
                                {!! Form::label('deliver_date', 'Delivery Date',['class'=>'col-md-4']) !!}

                                <div class="col-md-8">
                                    {!! Form::text('delivery_date', old('delivery'), ['class' => 'form-control date']) !!}
                                    {!! $errors->first('deliver_date', '<span class="help-block">:message</span>') !!}
                                </div>
                            </div>
                        </div>

                        <!-- Start inventory item Section -->
                        <div class="col-md-12">
                            <table class="items table  table-striped" id="tab_logic">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-center" style="width: 10%;">Quantity</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr id='addr0'>
                                        <td><select name="item0" class="select2-single" style="width: 100%"></select></td>
                                        <td><input type="text" name='qty0' placeholder='Quantity' value="1"/></td>
                                        <td>
                                            <button class="btn btn-xs btn-danger remove"><i class="fa fa-trash-o"></i></button>
                                        </td>
                                    </tr>
                                    <tr id='addr1'></tr>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td><a id="add_row" class="btn btn-primary btn-sm pull-left"><i class="fa fa-plus"></i> Add</a>
                                        </td>
                                    </tr>
                                    </tfoot>
                            </table>
                        </div>

                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa fa-send-o"></i> Continue
                                </button>
                            </div>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        var PRODUCTS_URL = "{{route('api.inventory.get_products')}}";
    </script>
    <script src="{!! m_asset('inventory:js/inorder_stub.js') !!}"></script>

@endsection