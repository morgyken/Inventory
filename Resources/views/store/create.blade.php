<div class="panel panel-info">
    <div class="panel-heading">Create internal store</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                {!! Form::open(['class'=>'form-horizontal','route'=>'inventory.store.save']) !!}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4">Store Name:</label>
                            <div class="col-md-8">
                                <input type="text" value="{{ old('name') }}" class="form-control" name="name">
                                {!! $errors->first('name', '<span class="help-block text-danger">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4">Select a parent store:</label>
                            <div class="col-md-8">
                                <select name="parent_store_id" class="form-control">
                                    <option selected disabled>Select a store</option>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('parent_store_id', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2">Description:</label>
                            <div class="col-md-10">
                                <textarea name="description" value="{{ old('description') }}" class="form-control"></textarea>
                                {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="main_store" class="col-md-4">Can order from supppliers:</label>
                            <div class="col-md-2">
                                <input id="main_store" type="checkbox" name="main_store" value="1" />
                                {!! $errors->first('main_store', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="delivery_store" class="col-md-4">Can update product prices:</label>
                            <div class="col-md-2">
                                <input id="delivery_store" type="checkbox" name="delivery_store" value="1" />
                                {!! $errors->first('delivery_store', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pull-right">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-save"></i> Save Store Details
                        </button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>