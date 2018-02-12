@extends('layouts.app')

@section('content_title', "$store->name")
@section('content_description','Manage products in store')

@section('content')
    @include('inventory::store.orders.includes.dashboard')

    <div class="panel panel-info">
        <div class="panel-heading"><b>{{ $store->name }}</b> - products in store</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12">
                    {{-- Search Form --}}
                    <form method="post" style="margin: 10px 0 30px 0">

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" required />
                            </div>

                            <div class="col-md-5">
                                <button type="submit" class="btn btn-primary btn-md">Search</button>
                            </div>
                        </div>

                    </form>

                    {!! Form::close() !!}
                    {{-- End of Search Form --}}

                    {!! Form::open() !!}
                        <table class="table table-striped" id="datatable">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th style="text-align: right">Cash Price</th>
                                    <th style="text-align: right">Insurance Price</th>
                                    <th style="text-align: right">Stock Adjustmets</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    @if($product->created_at >= \Carbon\Carbon::parse("6th February 2018"))
                                        <tr>
                                            <td>{{ $product->product_code }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->pivot->quantity }}</td>
                                            <td style="text-align: right">
                                                <input type="text" name="cash{{$product->id}}"
                                                       pid="{{$product->id}}"
                                                       value="{{ $product->pivot->selling_price }}"
                                                       {{ $store->delivery_store ?: 'disabled' }} />
                                            </td>
                                            <td style="text-align: right">
                                                <input type="text" name="cash{{$product->id}}"
                                                       pid="{{$product->id}}"
                                                       value="{{ number_format($product->pivot->insurance_price, 2) }}"
                                                       {{ $store->delivery_store ?: 'disabled' }} />
                                            </td>

                                            {{-- Ensure only authorised people can do this --}}
                                            <td style="text-align: right">
                                                <a href="#" id="adjust-{{ $product->id }}-{{ $product->name }}" class="btn btn-primary btn-sm adjust" data-toggle="modal" data-target="#adjustStock">Adjust Stock</a>
                                            </td>
                                            {{-- End of authorization --}}
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="5">Sorry! This store does not have any products</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="pull-right">
                            @if(method_exists($products, 'links'))
                                {{ $products->links() }}
                            @endif
                        </div>


                        @if($store->delivery_store)
                            <button type="button" class="btn btn-primary" id="save">
                                Update Prices
                            </button>
                        @endif


                    {!! Form::close() !!}
                </div>

                {{--Adjust Stock Modal--}}
                <div id="adjustStock" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Adjust stock for <span id="productName"></span></h4>
                            </div>
                            <div class="modal-body">
                                <form id="adjust-form" action="{{ url('inventory/stores/adjust-stock') }}" method="post">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="product_id" name="product_id" />
                                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                                    <div class="form-group">
                                        <label for="">Enter New Quantity</label>
                                        <input type="text" name="quantity" class="form-control" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="">Enter Reason for Adjusting Stock</label>
                                        <textarea cols="30" rows="10" class="form-control" name="reason" required></textarea>
                                    </div>

                                    <button class="btn btn-success">Adjust Stock</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                var data = [], arrIndex = {};

                function addOrReplace(object) {
                    var index = arrIndex[object.product];
                    if (index === undefined) {
                        index = data.length;
                        arrIndex[object.product] = index;
                    }
                    data[index] = object;
                }

                // $('#datatable').dataTable();

                $(document).on('keyup', 'input[type=text]', function () {
                    var product = $(this).attr('pid');
                    var update = {
                        product: product,
                        cash: $('input[name=cash' + product + ']').val(),
                        insurance: $('input[name=insurance' + product + ']').val()
                    };
                    addOrReplace(update);
                });
                $('#save').click(function () {
                    $.ajax({
                        url: "{{route('api.inventory.product.price.edit')}}",
                        method: 'POST',
                        data: {
                            _token: "{{csrf_token()}}",
                            data: data
                        },
                        dataType: "json",
                        success: function () {
                            alertify.success("Updates saved");
                            data = [];
                            arrIndex = {};
                        },
                        error: function () {
                            alertify.error("An error occurred");
                        }
                    });
                });

                $("body").on('click', '.adjust', function(event){

                    $("#productName").html('');

                    var productId = event.target.id.split("-")[1];

                    var productName = event.target.id.split("-")[2];

                    $("#productName").html(productName);

                    $("#product_id").val(productId);

                });
            });
        </script>
    </div>
@endsection
