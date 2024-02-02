@extends('site.layout')

@section('page_title', __('orders.orders') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-4">{{ __('orders.orders') }}</h3>

        <x-order />
        <x-order />
    </div>
@endsection