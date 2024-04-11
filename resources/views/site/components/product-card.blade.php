@props([
    'sku',
    'page' => 'catalog',
])

<div class="product-card">
    <div class="product-card_image-cont">
        <a href="{{ $sku->url }}" class="product-card_image-link">
            <img src="{{ $sku->image_md }}" class="product-card_image" alt="{{ $sku->name }}">
            <div class="image-link-tint"></div>
        </a>
        @if($sku->promo_id && $page !== 'promo')
            <a href="{{ route('promo', $sku->promo_url_slug) }}" class="product-card_badge-link" title="{{ $sku->promo_name }}">-{{ $sku->discount_prc }}%</a>
        @elseif($sku->discount_prc)
            <div class="product-card_badge">-{{ $sku->discount_prc }}%</div>
        @endif
    </div>
    <a href="{{ $sku->url }}" class="product-card_name mb-1">
        {{ $sku->name }}
    </a>
    <div class="product-card_description mb-1">
        {{ $sku->short_descr }}
    </div>

    <x-rating size="small"
              mb="1"
              :url="$sku->url . '/reviews'"
              :rating="$sku->rating"
              :ratingformatted="$sku->rating_formatted"
              :num="$sku->vote_num"/>

    <div class="mb-2">
        @if($sku->discount_prc)
            <div class="product-card_old-price">
                <del>{!! $sku->price_formatted !!}</del>
            </div>
        @endif
        <div class="product-card_price">{!! $sku->final_price_formatted !!}</div>
    </div>

    <div class="product-card_cart-btns-cont">
        <x-quantity-btns :skuid="$sku->id" :incart="$sku->in_cart" :twosizes="true" :hidden="!$sku->in_cart" />

        <button class="btn-2sizes catalog-add-to-cart-btn {{ $sku->in_cart ? 'hidden' : '' }}" data-id="{{ $sku->id }}">{{ __('cart.buttons.add_to_cart') }}</button>
    </div>

    <div class="product-btn-cont small">
        <x-product-btn-compare :id="$sku->id" :catid="$sku->category_id" :active="$sku->is_comparing" />
        <x-product-btn-favorites :id="$sku->id" :active="$sku->is_favorite" />
    </div>
</div>