@extends('layouts.app')

@section('content_title','New Internal Store')
@section('content_description','Manage Internal Stores')

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">
                Manage Internal Stores
            </h3>
        </div>
        <div class="box-body">
            {!! Form::open(['class'=>'form-horizontal','route'=>'inventory.store.save']) !!}
            <div class="box-header with-border">
                <h3 class="box-title">Store details</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4">Store Name:</label>
                            <div class="col-md-8">
                                <input type="text" value="" class="form-control" name="name">
                                {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
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
                                <textarea name="description" value='' class="form-control"></textarea>
                                {!! $errors->first('desc', '<span class="help-block">:message</span>') !!}
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

                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-send-o"></i> Save Details
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
            
            @include('inventory::store.index')
        </div>
    </div>
@endsection