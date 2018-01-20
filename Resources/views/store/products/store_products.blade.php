@extends('layouts.app')

@section('content_title','Products in store')
@section('content_description','Manage products in store')

@section('content')
    <div class="panel panel-info">
        <div class="panel-heading"><b>{{ $store->name }}</b> - products in store</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open() !!}

                        <table class="table table-striped" id="store-products">
                            <thead>
                            <tr>
                                <th>Item Code</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th style="text-align: right">Cash Price</th>
                                <th style="text-align: right">Insurance Price</th>
                            </tr>
                            </thead>
                            @forelse($store->products as $product)
                                <tr>
                                    <td>{{ $product->product_code }}</td>
                                    <td>{{ $product->desc }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td style="text-align: right">
                                        <input type="text" name="cash{{$product->id}}"
                                               pid="{{$product->id}}"
                                               value="{{ $product->pivot->selling_price }}"/>
                                    </td>
                                    <td style="text-align: right">
                                        <input type="text" name="cash{{$product->id}}"
                                               pid="{{$product->id}}"
                                               value="{{ number_format($product->pivot->insurance_price, 2) }}"/>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    Sorry! This store does not have any products
                                </tr>
                            @endforelse
                        </table>
                        <td>
                            <button type="button" class="btn btn-primary" id="save">
                                Update Prices
                            </button>
                        </td>


                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    {{--<script type="text/javascript">--}}
        {{--$(document).ready(function () {--}}
            {{--var data = [], arrIndex = {};--}}

            {{--function addOrReplace(object) {--}}
                {{--var index = arrIndex[object.product];--}}
                {{--if (index === undefined) {--}}
                    {{--index = data.length;--}}
                    {{--arrIndex[object.product] = index;--}}
                {{--}--}}
                {{--data[index] = object;--}}
                {{--console.log(data);--}}
            {{--}--}}

            {{--$('#datatable').dataTable();--}}
            {{--$(document).on('keyup', 'input[type=text]', function () {--}}
                {{--var product = $(this).attr('pid');--}}
                {{--var update = {--}}
                    {{--product: product,--}}
                    {{--cash: $('input[name=cash' + product + ']').val(),--}}
                    {{--insurance: $('input[name=insurance' + product + ']').val()--}}
                {{--};--}}
                {{--addOrReplace(update);--}}
            {{--});--}}
            {{--$('#save').click(function () {--}}
                {{--$.ajax({--}}
                    {{--url: "{{route('api.inventory.product.price.edit')}}",--}}
                    {{--method: 'POST',--}}
                    {{--data: {--}}
                        {{--_token: "{{csrf_token()}}",--}}
                        {{--data: data--}}
                    {{--},--}}
                    {{--dataType: "json",--}}
                    {{--success: function () {--}}
                        {{--alertify.success("Updates saved");--}}
                        {{--data = [];--}}
                        {{--arrIndex = {};--}}
                    {{--},--}}
                    {{--error: function () {--}}
                        {{--alertify.error("An error occurred");--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}
@endsection