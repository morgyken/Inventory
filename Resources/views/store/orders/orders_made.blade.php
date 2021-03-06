@extends('layouts.app')

@section('content_title', $store->name)
@section('content_description', "manage store stock movement")

@section('content')

    @include('inventory::store.orders.includes.dashboard')

    @include('inventory::store.orders.includes.requests.form')

    @include('inventory::store.orders.includes.requests.orders_made_listing')

    {{--@if($product->created_at >= \Carbon\Carbon::parse("6th February 2018"))--}}

@endsection