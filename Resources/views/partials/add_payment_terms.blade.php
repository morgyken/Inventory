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
$terms = $data['terms'];
?>

<div class="row">
    <div class="form-horizontal">
        {!! Form::open() !!}
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('terms') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Term</label>
                    <div class="col-md-8">
                        <input type="text" name="terms" class="form-control" value="{{old('name',$terms->terms)}}"/>
                        {!! $errors->first('terms', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }} req">
                    <label class="control-label col-md-4">Description</label>
                    <div class="col-md-8">
                        <textarea name="description"
                                  class="form-control">{{old('description',$terms->description)}}</textarea>
                        {!! $errors->first('description', '<span class="help-block">:message</span>') !!}
                    </div>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <hr/>
</div>