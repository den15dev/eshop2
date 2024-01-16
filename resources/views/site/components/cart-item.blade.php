<div class="cart-item">
    <div class="cart-item_number">{{ $num }}</div>

    <a href="{{ $product->url }}" class="cart-item_image-link">
        <img src="{{ asset('storage/images/products/' . $product->id . '/01_230.jpg') }}" alt="{{ $product->name }}">
        <div class="image-link-tint"></div>
    </a>

    <div class="flex-wrap-separator"></div>

    <div class="cart-item_details">
        <a href="{{ $product->url }}" class="cart-item_name dark-link">
            {{ $product->name }}
        </a>
        <div class="cart-item_short-descr small">
            {{ $product->short_descr }}
        </div>

        <x-cart-item-price :product="$product" />
    </div>

    <x-cart-item-price type="mobile" :product="$product" />

    <div class="cart-item_qty-sum-cont">
        <div class="quantity-btns">
            <button class="btn-qty-minus">
                <svg viewBox="0 0 10 2"><use href="#minusIcon"/></svg>
            </button>
            <input name="qty" type="text" value="1">
            <button class="btn-qty-plus">
                <svg viewBox="0 0 12 12"><use href="#plusIcon"/></svg>
            </button>
        </div>

        <div class="cart-item_sum">
            @if($product->discount_prc)
                <div class="product-card_old-price">
                    <del>{{ number_format($product->price, 0, ',', ' ') }} ₽</del>
                </div>
            @endif
            <div class="product-card_price">{{ number_format($product->final_price, 0, ',', ' ') }} ₽</div>
        </div>
    </div>

    <div class="cart-item_btns">
        <div class="btn-icon" role="button">
            <span class="icon-x-lg"></span>
        </div>
    </div>
</div>