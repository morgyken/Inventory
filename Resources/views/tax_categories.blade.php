<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */
?>

@extends('layouts.app')
@section('content_title','Tax Categories')
@section('content_description','Manage tax categories')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Add/Edit category</h3>
    </div>
    <div class="box-body">
        @include('inventory::partials.add_tax_category')
        <div class="row">
            <div class="col-md-12">
                @if(!$data['tax_categories']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['tax_categories'] as $category)
                        <tr id="category{{$category->id}}">
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->rate}}</td>
                            <td>
                                <a href="{{route('inventory.tax_categories',$category->id)}}"
                                   class="btn btn-primary btn-xs">
                                    <i class="fa fa-edit"></i> Edit</a> |
                                <button class="btn btn-danger btn-xs delete" value="{{$category->id}}">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th style="width: 70%;">Tax rate</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No categories added</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection