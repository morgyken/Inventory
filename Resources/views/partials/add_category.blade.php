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
$category = $data['category'];
?>

<div class="row">
    <div class="form-horizontal">
        {!! Form::open() !!}
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Category Name</label>
                    <div class="col-md-8">
                        <input type="text" name="name" class="form-control" value="{{old('name',$category->name)}}"
                               placeholder="Product category name"/>
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('parent_category') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Parent Category</label>
                    <div class="col-md-8">
                        <select name="parent_category" class="form-control">
                            @foreach($data['product_categories'] as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @endforeach
                            <option selected="selected" value="0">None</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('cash_markup') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Cash Markup %</label>
                    <div class="col-md-8">
                        {!! Form::text('cash_markup',old('cash_markup',$category->cash_markup),['class'=>'form-control','placeholder'=> 'eg. 30']) !!}
                        {!! $errors->first('cash_category', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('credit_markup') ? ' has-error' : '' }}">
                    <label class="control-label col-md-4">Insurance Markup %</label>
                    <div class="col-md-8">
                        {!! Form::text('credit_markup',old('credit_markup',$category->credit_markup),['class'=>'form-control','placeholder'=>'eg. 36']) !!}
                        {!! $errors->first('credit_markup', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>

                <div class="pull-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>