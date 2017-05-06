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

@section('content_title','View Suppliers')
@section('content_description','Manage suppliers')

@section('content')
<div class="box box-info">
    @include('inventory::add_supplier')

    <div class="box-header with-border">
        <h3 class="box-title">Suppliers</h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                @if(!$data['suppliers']->isEmpty())
                <table class="table table-responsive table-striped">
                    <tbody>
                        @foreach($data['suppliers'] as $supplier)
                        <tr id="supplier{{$supplier->id}}">
                            <td>{{$supplier->id}}</td>
                            <td>{{$supplier->name}}</td>
                            <td>{{$supplier->telephone}}</td>
                            <td>{{$supplier->email}}</td>
                            <td>{{$supplier->address}} {{$supplier->post_code}} {{$supplier->town}}</td>
                            <td>
                                <a href="{{route('inventory.suppliers',$supplier->id)}}"
                                   class="btn btn-primary btn-xs">
                                    <i class="fa fa-edit"></i> Edit</a> <!--|
                                <button class="btn btn-danger btn-xs delete" value="{{$supplier->id}}">
                                    <i class="fa fa-trash-o"></i> Delete
                                </button>-->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
                @else
                <div class="alert alert-info">
                    <p>No suppliers added</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection