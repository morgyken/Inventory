<div class="panel panel-info">
    <div class="panel-heading">Make an order</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['class'=>'form-horizontal', 'route'=>['inventory.store.make-order', 'storeId' => $store->id]]) !!}

                {!! Form::hidden('ordered_by', Auth::user()->id) !!}

                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('store') ? ' has-error' : '' }} req">
                        {!! Form::label('dispatching_store', 'Dispatching Store',['class'=>'col-md-4']) !!}

                        <div class="col-md-8">
                            {!! Form::select('dispatching_store', $dispatchingStores, null, ['class'=>'form-control', 'id' => 'dispatching-store']) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group {{ $errors->has('deliver_date') ? ' has-error' : '' }} req">
                        {!! Form::label('delivery_date', 'Delivery Date',['class'=>'col-md-4']) !!}

                        <div class="col-md-8">
                            {!! Form::text('delivery_date', old('delivery_date'), ['class' => 'form-control date']) !!}
                            {!! $errors->first('delivery_date', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <label class="col-md-6">Item</label>
                <label class="col-md-4">Quantity</label>
                <label class="col-md-2">remove</label>

                <div id="item-container">
                    <div id="item-0" class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-6">
                                <select name="items[0][product_id]" class="col-md-12"></select>
                            </div>
                            <div class="col-md-4">
                                <input name="items[0][quantity]" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <a id="add-row" class="btn btn-primary btn-sm pull-left"><i class="fa fa-plus"></i> Add Item</a>
                </div>

                <div class="col-md-12">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-send-o"></i> Make Order
                        </button>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    {{--var PRODUCTS_URL = "{{ route('api.inventory.get_products') }}";--}}
    var PRODUCTS_URL = "{{ route('api.inventory.get.orderproducts') }}";
</script>
<script src="{!! m_asset('inventory:js/inorder_stub.js') !!}"></script>