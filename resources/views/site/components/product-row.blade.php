<div class="product-row">
    <div class="product-row_image-cont">
        <a href="{{ $product->url }}" class="product-row_image-link">
            <img src="{{ $product->image_md }}" class="product-row_image" alt="{{ $product->name }}">
            <div class="image-link-tint"></div>
        </a>
        @if($product->promo_id)
            <a href="{{ route('promo', $product->promo_url_slug) }}" class="product-card_badge-link" title="{{ $product->promo_name }}">-{{ $product->discount_prc }}%</a>
        @elseif($product->discount_prc)
            <div class="product-card_badge">-{{ $product->discount_prc }}%</div>
        @endif
    </div>

    <div class="product-row_main-cont">
        <a href="{{ $product->url }}" class="product-card_name mb-1">
            {{ $product->name }}
        </a>
        <div class="product-row_description mb-1">
            {{ $product->short_descr }}
        </div>

        <x-rating size="small"
                  mb="2"
                  :url="$product->reviews_url"
                  :rating="$product->rating"
                  :num="$product->vote_num"/>

        <div class="product-row_group1">
            <div class="mb-2">
                @if($product->discount_prc)
                    <div class="product-card_old-price">
                        <del>{!! $product->price_formatted !!}</del>
                    </div>
                @endif
                <div class="product-card_price">{!! $product->final_price_formatted !!}</div>
            </div>

            <button class="btn-2sizes catalog-add-to-cart-btn">{{ __('catalog.product_card.add_to_cart') }}</button>
        </div>

        <div class="product-btn-cont small btns-row">
            <x-product-btn-compare :id="$product->id" :catid="$product->category_id" :active="$product->is_comparing" />
            <x-product-btn-favorites :id="$product->id" :active="$product->is_favorite" />
        </div>
    </div>
</div>