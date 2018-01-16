@extends('layouts.app')

@section('content_title', "Manage Store")
@section('content_description', "manage store stock movement")

@section('content')

    @include('inventory::store.orders.includes.dashboard')

    @include('inventory::store.orders.includes.requests.form')

    @include('inventory::store.orders.includes.requests.table')

@endsection