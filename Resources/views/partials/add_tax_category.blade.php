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
$tax = $data['category'];
?>

<div class="row">
    <div class="form-horizontal">
        {!! Form::open() !!}
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Category Name</label>
                    <div class="col-md-8">
                        <input type="text" name="name" class="form-control" value="{{old('name',$tax->name)}}"/>
                        {!! $errors->first('name', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('rate') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Tax Rate</label>
                    <div class="col-md-8">
                        <input name="rate" class="form-control" value="{{old('rate',$tax->rate)}}" placeholder="eg. 0.16"/>
                        {!! $errors->first('rate', '<span class="help-block">:message</span>') !!}
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