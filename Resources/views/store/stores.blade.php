<?php
extract($data);
?>

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
            {!! Form::open(['class'=>'form-horizontal','route'=>'inventory.store.save_store']) !!}
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
                            <label class="col-md-4">Description:</label>
                            <div class="col-md-8">
                                <textarea name="desc" value='' class="form-control"></textarea>
                                {!! $errors->first('desc', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="pull-right">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-send-o"></i> Continue
                    </button>
                </div>
            </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    @if(!$stores->isEmpty())
                        <table class="table table-responsive table-striped">
                            <tbody>
                            @foreach($stores as $store)
                                <tr id="supplier{{$store->id}}">
                                    <td>{{$store->id}}</td>
                                    <td>{{$store->name}}</td>
                                    <td>{{$store->created_at}}</td>
                                    <td>
                                        <a href="{{route('inventory.store.stores',$store->id)}}"
                                           class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i> Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <thead>
                            <tr>
                                <th>Store Id</th>
                                <th>Store Name</th>
                                <th>Date Added</th>
                                <th></th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <div class="alert alert-info">
                            <p>No Store has been created</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection