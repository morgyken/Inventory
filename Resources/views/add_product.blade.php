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
extract($data);
?>

@extends('layouts.app')
@section('content_title','Manage Products')
@section('content_description','Manage product details')

@section('content')
    {!! Form::open(['class'=>'form-horizontal','route'=>'inventory.add_product']) !!}
    @if($data['product']->id)
        <input type="hidden" name="id" value="{{$product->id}}">
    @endif
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Add/Edit product</h3>
        </div>
        <div class="box-body">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('category') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Category</label>
                    <div class="col-md-8">
                        {!! Form::select('category',get_product_categories(),null,['class'=>'form-control','placeholder'=>'Select...','id'=>'category']) !!}
                        {!! $errors->first('category', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Name</label>
                    <div class="col-md-8">
                        <input type="text" name="name" class="form-control" value="{{old('name',$product->name)}}"/>
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('unit') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Unit of measure</label>
                    <div class="col-md-8">
                        {!! Form::select('unit',get_units_of_measure(),null,['class'=>'form-control']) !!}
                        {!! $errors->first('unit', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('tax') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Tax group</label>
                    <div class="col-md-8">
                        {!! Form::select('tax',get_tax_groups(),old('tax',$product->tax),['class'=>'form-control']) !!}
                        {!! $errors->first('tax', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="drug-group">
                    <div class="form-group {{ $errors->has('strength') ? ' has-error' : '' }} req">
                        <label class="control-label col-md-4">Strength</label>
                        <div class="col-md-8">
                            {!! Form::text('strength',old('strength',$product->strength),['class'=>'form-control']) !!}
                            {!! $errors->first('strength', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('formulation') ? ' has-error' : '' }} req">
                        <label class="control-label col-md-4">Formulation</label>
                        <div class="col-md-8">
                            {!! Form::select('formulation',config('inventory.formulation'),old('formulation',$product->formulation),['class'=>'form-control']) !!}
                            {!! $errors->first('formulation', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('label_type') ? ' has-error' : '' }} req">
                        <label class="control-label col-md-4">Label Type</label>
                        <div class="col-md-8">
                            {!! Form::select('label_type',mconfig('inventory.label_type'),old('label_type',$product->label_type),['class'=>'form-control']) !!}
                            {!! $errors->first('label_type', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Description</label>
                    <div class="col-md-8">
                        {!! Form::textarea('description',old('description',$product->description),['class'=>'form-control','rows'=>4]) !!}
                        {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

            <!--
            <div class="form-group {{ $errors->has('unit_cost') ? ' has-error' : '' }} req">
                <label class="control-label col-md-4">Unit Cost</label>
                <div class="col-md-8">
                    {!! Form::text('unit_cost',old('unit_cost',$product->unit_cost),['class'=>'form-control']) !!}
            {!! $errors->first('unit_cost', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('selling_price') ? ' has-error' : '' }}">
                <label class="control-label col-md-4">Selling Price</label>
                <div class="col-md-8">
                    {!! Form::text('selling_price',old('selling_price',$product->selling_price),['class'=>'form-control']) !!}
            {!! $errors->first('selling_price', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                -->
            </div>
        </div>
        <div class="box-footer">
        <span class="pull-right"><button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Save</button> </span>
        </div>
    </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $('.drug-group').hide();
        $(document).ready(function () {
            $('#category').change(function () {
                var value = $(this).val();
                if (value === '1') {
                    $('.drug-group').show();
                } else {
                    $('.drug-group').hide();
                }
            });
        });
    </script>
@endsection