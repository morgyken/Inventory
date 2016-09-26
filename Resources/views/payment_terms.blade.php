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
@section('content_title','Payment Terms')
@section('content_description','View and administer payment terms')

@section('content')
    <div class="row">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Payment Terms</h3>
            </div>
            <div class="box-body">
                @include('inventory::partials.add_payment_terms')
                <div class="row">
                    <div class="col-md-12">
                        @if(!$data['payment_terms']->isEmpty())
                            <table class="table table-responsive table-striped">
                                <tbody>
                                @foreach($data['payment_terms'] as $terms)
                                    <tr id="category{{$terms->id}}">
                                        <td>{{$terms->id}}</td>
                                        <td>{{$terms->terms}}</td>
                                        <td>{{$terms->description}}</td>
                                        <td>
                                            <a href="{{route('inventory.tax_categories',$terms->id)}}"
                                               class="btn btn-primary btn-xs">
                                                <i class="fa fa-edit"></i> Edit</a> |
                                            <button class="btn btn-danger btn-xs delete" value="{{$terms->id}}">
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
                                <p>No payment terms </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection