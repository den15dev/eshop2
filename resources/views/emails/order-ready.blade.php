@extends('emails.layout')

@section('page_title', __('notifications.order_ready.subject', ['num' => $order->id], $order->language_id))

@section('main_content')
    <h3 style="margin-top: 0; font-size: 18px;">{{ __('notifications.greeting', ['name' => $order->name], $order->language_id) }}</h3>

    <p>{!! __('notifications.order_ready.body', [
                'id' => $order->id,
                'total_cost_formatted' => $order->total_cost_formatted,
                'shop_address' => $order->shop->getTranslation('address', $order->language_id),
                'orders_link' => '<a href="' . $order->local_url . '" style="color: #716EF6;">' . __('orders.orders', [], $order->language_id) . '</a>',
            ], $order->language_id) !!}</p>

    <p>{{ __('notifications.signature1', [], $order->language_id) }}<br>{{ __('notifications.signature2', [], $order->language_id) }}</p>
@endsection

@section('footer'){!! __('notifications.order_ready.footer', ['link' => $footer_home_link], $order->language_id) !!}@endsection