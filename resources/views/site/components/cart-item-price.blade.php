@php
    $classname = isset($type) && $type === 'mobile'
        ? 'cart-item_id-price-mobile'
        : 'cart-item_id-price';
@endphp

<div class="{{ $classname }}">
    <div class="cart-item_product-id">
        {{ __('product.product_id') }}: {{ $sku->id }}
    </div>
    <div>
        @if($sku->discount_prc)
            <div class="product-card_old-price">
                <del>{!! $sku->price_formatted !!}</del>
            </div>
        @endif
        <div class="product-card_price">{!! $sku->final_price_formatted !!}</div>
    </div>
</div>