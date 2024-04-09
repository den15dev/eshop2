@extends('site.layout')

@section('page_title', __('orders.order_num', ['num' => $order->id]) . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h4 class="mt-2">{{ __('orders.new_created', ['num' => $order->id]) }}</h4>

        <div class="mb-4">
            {!! __('orders.new_message', ['link' => '<a href="' . route('orders') . '" class="link">' . __('orders.orders') . '</a>']) !!}
        </div>

        <x-order :order="$order" :new="true" />
    </div>
@endsection