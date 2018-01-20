@extends('layouts.app')

@section('content_title','Internal stores')
@section('content_description','Manage internal stores')

@section('content')

    @include('inventory::store.includes.store_form')

    @include('inventory::store.includes.stores_listing')

@endsection