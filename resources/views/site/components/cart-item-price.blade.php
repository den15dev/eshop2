@php
    $classname = isset($type) && $type === 'mobile'
        ? 'cart-item_id-price-mobile'
        : 'cart-item_id-price';
@endphp

<div class="{{ $classname }}">
    <div class="cart-item_product-id">
        {{ __('product.product_id') }}: {{ $product->id }}
    </div>
    <div>
        @if($product->discount_prc)
            <div class="product-card_old-price">
                <del>{{ number_format($product->price, 0, ',', ' ') }} ₽</del>
            </div>
        @endif
        <div class="product-card_price">{{ number_format($product->final_price, 0, ',', ' ') }} ₽</div>
    </div>
</div>