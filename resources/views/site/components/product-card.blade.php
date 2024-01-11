@php
    $url = route('product', [$product->category_slug, $product->slug . '-' . $product->id]);
@endphp

<div class="product-card">
    <a href="{{ $url }}" class="product-card_image-link">
        <img src="{{ asset('storage/images/products/1/01_230.jpg') }}" class="product-card_image" alt="{{ $product->name }}">
        <div class="tint"></div>
    </a>
    <a href="{{ $url }}" class="product-card_name mb-1">
        {{ $product->name }}
    </a>
    <div class="product-card_description mb-1">
        {{ $product->short_descr }}
    </div>

    <x-rating size="small"
              mb="1"
              :url="route('reviews', [$product->category_slug, $product->slug . '-' . $product->id])"
              :rating="$product->rating"
              :num="$product->vote_num"/>

    <div class="mb-2">
        @if($product->discount_prc)
            <div class="product-card_old-price">
                <del>{{ $product->price }} ₽</del>
            </div>
        @endif
        <div class="product-card_price">{{ $product->final_price }} ₽</div>
    </div>

    <button class="btn-2sizes catalog-add-to-cart-btn">{{ __('catalog.product_card.add_to_cart') }}</button>

    <x-product-btns size="small" :id="$product->id"/>
</div>