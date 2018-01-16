<div class="panel panel-info">
    <div class="panel-heading">Update {{ $store->name }} store</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($store, ['class'=>'form-horizontal', 'route' => ['inventory.store.update', $store->id]]) !!}
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4">Store Name:</label>
                        <div class="col-md-8">
                            <input type="text" value="{{ $store->name }}" class="form-control" name="name">
                            {!! $errors->first('name', '<span class="help-block text-danger">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4">Select a parent store:</label>
                        <div class="col-md-8">
                            <select name="parent_store_id" class="form-control">
                                <option>Select a store</option>
                                @foreach($stores as $parents)
                                    <option value="{{ $parents->id }}" {{ $store->id != $parents->id ?: 'selected' }}>
                                        {{ $parents->name }}
                                    </option>
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
                            <textarea name="description" value="{{ $store->description }}" class="form-control"></textarea>
                            {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="main_store" class="col-md-4">Can order from supppliers:</label>
                        <div class="col-md-2">
                            <input id="main_store" type="checkbox" name="main_store" value="1" {{ !$store->main_store ?: 'checked' }} />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="delivery_store" class="col-md-4">Can update product prices:</label>
                        <div class="col-md-2">
                            <input id="delivery_store" type="checkbox" name="delivery_store" value="1" {{ !$store->delivery_store ?: 'checked' }} />
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