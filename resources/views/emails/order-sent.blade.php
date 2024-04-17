@extends('emails.layout')

@section('page_title', __('notifications.order_sent.subject', ['num' => $order->id]))

@section('main_content')
    <h3 style="margin-top: 0; font-size: 18px;">{{ __('notifications.greeting', ['name' => $order->name]) }}</h3>

    <p>{!! __('notifications.order_sent.body', [
                'id' => $order->id,
                'total_cost_formatted' => $order->total_cost_formatted,
                'orders_link' => '<a href="' . $order->local_url . '" style="color: #716EF6;">' . __('orders.orders') . '</a>',
            ]) !!}</p>

    <p>{{ __('notifications.signature1') }}<br>{{ __('notifications.signature2') }}</p>
@endsection

@section('footer'){!! __('notifications.order_sent.footer', ['link' => $footer_home_link]) !!}@endsection