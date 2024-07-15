@props([
    'order',
    'mb' => 'mb-6',
])

<div class="{{ $mb }}">
    @if(!isset($new))
        <div class="order-title fw-bold mb-1">{{ __('orders.num', ['num' => $order->id]) }}</div>
    @endif

    <ul class="order_details-cont mb-25">
        <li>
            <span class="lightgrey-text">{{ __('orders.created_at') }}:</span>
            {{ $order->date }}
        </li>
        <li>
            <span class="lightgrey-text">{{ __('orders.status') }}:</span>
            <span class="order-status_{{ $order->status->value }}">{{ $order->status->description() }}</span>
        </li>
        <li>
            <span class="lightgrey-text">{{ __('orders.payment_status') }}:</span>
            <span class="payment-status_{{ $order->payment_status->value }}">{{ $order->payment_status->description() }}</span>
        </li>
        <li>
            <span class="lightgrey-text">{{ __('orders.payment_method') }}:</span>
            {{ $order->payment_method->description() }}
        </li>
        <li>
            <span class="lightgrey-text">{{ __('orders.delivery_method') }}:</span>
            {{ $order->delivery_method->description() }}
        </li>
        <li>
            @if($order->delivery_method->name === 'Delivery')
                <span class="lightgrey-text">{{ __('orders.delivery_address') }}:</span>
                {{ $order->delivery_address }}
            @elseif($order->delivery_method->name === 'SelfDelivery')
                <span class="lightgrey-text">{{ __('orders.store_address') }}:</span>
                {{ $order->shop->address }}
            @endif
        </li>
    </ul>

    <table class="order-table">
        <thead class="order-table_head">
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ __('orders.product_id') }}</td>
                <td>{{ __('orders.price') }}</td>
                <td><span class="order-table_qty-text">{{ __('orders.quantity') }}</span></td>
                <td>{{ __('orders.total') }}</td>
            </tr>
            <tr>
                <td colspan="7" class="order-table_line"></td>
            </tr>
        </thead>
        <tbody class="order-table_body">
            @foreach($order->orderItems as $order_item)
                <x-order-item :index="$loop->index + 1" :item="$order_item" />
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7" class="order-table_line"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="total">{!! $order->items_cost_formatted !!}</td>
            </tr>
        </tfoot>
    </table>
</div>
