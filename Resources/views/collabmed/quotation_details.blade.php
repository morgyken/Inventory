<?php
/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Bravo Kiptoo
 *
 * =============================================================================
 */
$quot = $data['quot'];
if ($data['supplier_account'] > 0) {
    $supplier_mode = 1;
}
?>

@extends('layouts.app')
@section('content_title','Quotation Details')
@section('content_description','')

@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Quotation details</h3>
    </div>
    <div class="box-body">
        {!! Form::open(['route'=>'inventory.collabmed.quotation.submit','class'=>'form-horizontal'])!!}
        <dl class="dl-horizontal">
            <dt>#:</dt>
            <dd>{{$quot->id}}</dd>
            <dt>Supplier:</dt>
            <dd>
                {{$quot->suppliers->name}}
                <input type="hidden" name="quotation" value="{{$quot->id}}">
            </dd>
            <dt>Date:</dt>
            <dd>{{smart_date($quot->created_at)}}</dd>
            <dt>Status</dt>
            <dd>
                @if($quot->status=='rejected')
                <span class="label label-danger">{{$quot->status}}</span>
                @elseif($quot->status=='accepted')
                <span class="label label-success">{{$quot->status}}</span>
                @else
                <span class="label label-info">{{$quot->status}}</span>
                @endif
            </dd>
        </dl>
        <div>
            <table class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Units Required</th>
                        <th>Unit Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quot->details as $item)
                    <tr>
                        <td>
                            {{$item->items->name}}
                            <input type="hidden" name="item[]" value="{{$item->items->id}}">
                        </td>
                        <td>
                            {{$item->units_required}}
                            <input type="hidden" name="required_units[]" value="{{$item->units_required}}">
                        </td>
                        <td>
                            @if(isset($supplier_mode))
                            <input type="text" name="unit_price[]" value="{{$item->unit_price?number_format($item->unit_price,2):''}}">
                            @else
                            {{$item->unit_price?number_format($item->unit_price,2):'____'}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total</th>
                        <th>{{$quot->total}}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="box-footer">
            <div class="btn-group ">
                <div class="form-group {{ $errors->has('supplier') ? ' has-error' : '' }} req">
                    @if(isset($supplier_mode))
                    <button class="btn btn-warning"><i  class="fa fa-list"></i>Submit Quotation</button>
                    @else
                    <a href="{{route('inventory.collabmed.quotation.accept', $quot->id)}}" class="btn btn-info"><i  class="fa fa-check"></i>Accept</a>
                    <a href="{{route('inventory.collabmed.quotation.reject', $quot->id)}}" class="btn btn-danger"><i  class="fa fa-times"></i>Reject</a>
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'pdf', 'print'
            ]
        });
    });
</script>
@endsection