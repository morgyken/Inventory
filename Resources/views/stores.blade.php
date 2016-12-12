<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Gidi (bkiptoo@collabmed.com)
 *
 * =============================================================================
 */
?>

@extends('layouts.app')

@section('content_title','New Store')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><a class="btn btn-primary btn-xs" href="{{route('inventory.stores')}}">
                <i class="fa fa-plus-square"></i> New Store
            </a>
        </h3>
    </div>
    <div class="box-body">
        {!! Form::open(['class'=>'form-horizontal']) !!}
        <div class="box-header with-border">
            <h3 class="box-title">Order details</h3>
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
                @if(!$data['stores']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['stores'] as $store)
                        <tr id="supplier{{$store->id}}">
                            <td>{{$store->id}}</td>
                            <td>{{$store->name}}</td>
                            <td>
                                <a href="{{route('inventory.store.manage',$store->id)}}"
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