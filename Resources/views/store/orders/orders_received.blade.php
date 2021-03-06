@extends('layouts.app')

@section('content_title', $store->name)
@section('content_description', "manage store stock movement")

@section('content')

    @include('inventory::store.orders.includes.dashboard')

    @include('inventory::store.orders.includes.received.table')

@endsection