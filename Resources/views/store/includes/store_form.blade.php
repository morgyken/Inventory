<div class="panel panel-info">
    <div class="panel-heading">Update {{ $store->name }}</div>
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
                                <option {{ $store->parent_store_id ?: 'selected' }}>Select a store</option>
                                @foreach($stores as $parents)
                                    <option value="{{ $parents->id }}" {{ $store->parent_store_id != $parents->id ?: 'selected' }}>
                                        {{ $parents->name }}
                                    </option>
                                @endforeach
                            </select>
                            {!! $errors->first('parent_store_id', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4">Select a department:</label>
                        <div class="col-md-8">
                            <select name="clinic" class="form-control">
                                <option selected disabled>Select a department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}"  {{ $store->clinic != $department->id ?: 'selected' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-md-4">Description:</label>
                        <div class="col-md-8">
                            <textarea name="description" class="form-control">{{ $store->description }}</textarea>
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