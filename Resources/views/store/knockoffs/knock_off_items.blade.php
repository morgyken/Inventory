@extends('layouts.app')

@section('content_title', $store->name)
@section('content_description', "knock off items from the  store")

@section('content')
    @include('inventory::store.orders.includes.dashboard')

    <div class="panel panel-info">
        <div class="panel-heading">Knock off items</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(['class'=>'form-horizontal', 'route'=>['inventory.store.knocked-off', 'storeId' => $store->id]]) !!}

                    {!! Form::hidden('knocked_by', Auth::user()->id) !!}

                    <label class="col-md-5">Item</label>
                    <label class="col-md-2">Quantity</label>
                    <label class="col-md-3">Reason</label>

                    <div id="item-container">
                        <div id="item-0" class="col-md-12">
                            <div class="form-group">
                                <div class="col-md-5">
                                    <select name="items[0][product_id]" class="col-md-12"></select>
                                </div>
                                <div class="col-md-2">
                                    <input name="items[0][quantity]" class="form-control" />
                                </div>
                                <div class="col-md-3">
                                    <input name="items[0][reason]" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <a id="add-row" class="btn btn-primary btn-sm pull-left"><i class="fa fa-plus"></i> Another One</a>
                    </div>

                    <div class="col-md-12">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-ban"></i> Knock Off Items
                            </button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var PRODUCTS_URL = "{{ route('api.inventory.get_products') }}";
    </script>
    <script src="{!! m_asset('inventory:js/inorder_stub.js') !!}"></script>
@endsection