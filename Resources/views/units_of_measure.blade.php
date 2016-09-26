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
@section('content_title','Units of measurement')
@section('content_description','View all units of measurement')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Add/Edit units of measurement</h3>
    </div>
    <div class="box-body">
        @include('inventory::partials.add_units_of_measure')
        <div class="row">
            <div class="col-md-12">
                @if(!$data['units_of_measure']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['units_of_measure'] as $category)
                        <tr id="category{{$category->id}}">
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->description}}</td>
                            <td>
                                <a href="{{route('inventory.units_of_measurement',$category->id)}}"
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
                            <th style="width: 70%;">Description</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No units of measurement added</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection