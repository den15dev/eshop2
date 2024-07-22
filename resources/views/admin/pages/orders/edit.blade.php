@extends('admin.layout')

@section('page_title',  __('admin/orders.order_managing_num', ['id' => $order->id]) . ' - ' . __('admin/general.admin_panel'))

@section('page_header', __('admin/orders.order_managing'))

@section('main_content')
    <div>
        <x-order :order="$order" mb="mb-4" :extended="true" />

        <div class="manage-btns-cont">
            @php
                $status = \App\Modules\Orders\Enums\OrderStatus::class;
                $delivery_method = \App\Modules\Orders\Enums\DeliveryMethod::class;
            @endphp

            @if($order->status === $status::Completed)
                <div class="btn btn-outlined-inactive">{{ __('admin/orders.status_buttons.completed') }}</div>

            @elseif($order->status !== $status::Cancelled)
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    @if($order->status === $status::New)
                        <input type="hidden" name="status" value="accepted">
                        <button type="submit">{{ __('admin/orders.status_buttons.accept') }}</button>
                    @elseif($order->status === $status::Accepted)
                        @if($order->delivery_method === $delivery_method::Delivery)
                            <input type="hidden" name="status" value="sent">
                            <button type="submit">{{ __('admin/orders.status_buttons.sent') }}</button>
                        @elseif($order->delivery_method === $delivery_method::SelfDelivery)
                            <input type="hidden" name="status" value="ready">
                            <button type="submit">{{ __('admin/orders.status_buttons.ready') }}</button>
                        @endif
                    @elseif($order->status === $status::Sent || $order->status === $status::Ready)
                        <input type="hidden" name="status" value="completed">
                        <button type="submit">{{ __('admin/orders.status_buttons.complete') }}</button>
                    @endif
                </form>

                <form action="{{ route('admin.orders.update', $order->id) }}" style="margin-left: auto;" method="POST" id="cancelOrderForm">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="status" value="cancelled">
                    <button type="submit" class="btn-bg-red">{{ __('admin/orders.status_buttons.cancel') }}</button>
                </form>

            @else
                <div class="btn btn-outlined-inactive">{{ __('admin/orders.status_buttons.cancelled') }}</div>
            @endif
        </div>
    </div>
@endsection
