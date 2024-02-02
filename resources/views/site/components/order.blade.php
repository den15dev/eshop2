<div class="mb-5">
    @if(!isset($new))
        <div class="order-title fw-bold mb-1">{{ __('orders.order_num', ['num' => 345]) }}</div>
    @endif

    <ul class="order_details-cont mb-25">
        <li>
            <span class="lightgrey-text">{{ __('orders.created_at') }}:</span>
            18.01.2024, 0:58
        </li>
        <li>
            <span class="lightgrey-text">{{ __('orders.status') }}:</span>
            <span class="order-status_new">новый</span>
        </li>
        <li>
            <span class="lightgrey-text">{{ __('orders.payment_status') }}:</span>
            <span class="payment-status_not-payed">не оплачен</span>
        </li>
        <li>
            <span class="lightgrey-text">{{ __('orders.payment_method') }}:</span>
            онлайн
        </li>
        <li>
            <span class="lightgrey-text">{{ __('orders.delivery_method') }}:</span>
            доставка
        </li>
        <li>
            <span class="lightgrey-text">{{ __('orders.address') }}:</span>
            Московская область, г. Зеленоград, ул. Красная слобода 25, кв. 16
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
            <x-order-item />
            <x-order-item />
            <x-order-item />
            <x-order-item />
            <x-order-item />
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
                <td class="total">283 541 ₽</td>
            </tr>
        </tfoot>
    </table>
</div>