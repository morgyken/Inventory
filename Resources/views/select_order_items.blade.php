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
$order = $data['order'];
?>

@extends('layouts.app')
@section('content_title','Local Purchase Order')
@section('content_description','Add items to order')

@section('content')
{!!  Form::open(['route'=>'inventory.complete_order','id'=>'lpo_form'])!!}
<div class="box box-info">
    <div class="box-header with-border">
        <dl class="dl-horizontal">
            <dt>Supplier</dt>
            <dd>{{get_suppliers($order['supplier'])}}<input type="hidden" name="supplier" value="{{$order['supplier']}}"/></dd>
            <dt>Delivery Date</dt>
            <dd>{{$order['delivery_date']}}<input type="hidden" name="delivery_date" value="{{$order['delivery_date']}}"/></dd>
            <dt>Payment Mode</dt>
            <dd>{{$order['payment_mode']}}<input type="hidden" name="payment_mode" value="{{$order['payment_mode']}}"/></dd>
        </dl>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12" id="products">
                    @if(!$data['products']->isEmpty())
                    <div class="alert alert-success">
                        <p id="message"></p>
                    </div>
                    <table class="table table-responsive table-striped">
                        <tbody>
                            @foreach($data['products'] as $product)
                            <tr id="product{{$product->id}}">
                                <td>{{$product->product_code}}</td>
                                <td class="name">{{$product->name}}</td>
                                <td>{{$product->categories->name}}</td>
                                <td><input type="text" name="price" value="{{$product->prices ? $product->prices->price:'0'}}"
                                           size="4" class="price"/></td>
                                <td><input type="text" name="qty" value="1" size="3" class="qty"/></td>
                                <td>
                                    <button class="btn btn-primary btn-xs select">
                                        <i class="fa fa-check-circle-o"></i> Select
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Cost</th>
                                <th>Qty</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                    <button type="submit" class="btn btn-success" id="complete"><i class="fa fa-send-o"></i>
                        Complete Order
                    </button>
                    @else
                    <div class="alert alert-info">
                        <p>No products to choose from. <a href="{{route('inventory.add_product')}}">Add products
                                first!</a></p>
                    </div>
                    @endif
                </div>
                <div class="col-md-5">
                    <table class="table table-success cart">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
<script type="text/javascript">
    $('#message').parent().hide();
    $('.cart').hide();
    $(document).ready(function () {
        var cart = [];
        $('.select').click(function (e) {
            e.preventDefault();
            var price = $(this).closest('tr').find('input[name=price]').val();
            var qty = $(this).closest('tr').find('input[name=qty]').val();
            var name = $(this).closest('tr').find('td.name').html();
            var id = $(this).closest('tr').attr('id').slice(-1);
            var item = {};
            item['price'] = price;
            item['quantity'] = qty;
            item['id'] = id;
            item['name'] = name;
            item['total'] = qty * price;

            $.each(cart, function (key, value) {
                if (value) {
                    if (value.id === id) {
                        cart.splice(key, 1);
                    }
                }
            });
            cart.push(item);
            update_cart();
        });
        function update_cart() {
            $('.cart tbody').empty();
            $('#products').removeClass('col-md-12').addClass('col-md-7');
            $('.cart').show();
            $('#message').parent().show();
            $('#message').html(cart.length + " items added to cart");
            $.each(cart, function (key, value) {
                if (value) {
                    $('.cart > tbody').append('<tr><td>' + value.name + '</td><td>' + value.price + '</td><td>' + value.quantity + '</td><td>' + value.total + '</td></tr>');
                }
            });
        }

        $('#complete').click(function (e) {
            var dataString = JSON.stringify(cart);
            $('<input />').attr('type', 'hidden')
                    .attr('name', "cart")
                    .attr('value', dataString)
                    .appendTo('#lpo_form');
            return true;
        });
    });
</script>
@endsection