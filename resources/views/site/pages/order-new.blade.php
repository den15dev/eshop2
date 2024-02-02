@extends('site.layout')

@section('page_title', __('orders.order_num', ['num' => 345]) . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h4 class="mt-2">{{ __('orders.new_created', ['num' => 345]) }}</h4>

        <div class="mb-4">
            {!! __('orders.new_message', ['link' => '<a href="' . route('orders') . '" class="link">' . __('orders.orders') . '</a>']) !!}
        </div>

        <x-order :new="true" />
    </div>
@endsection