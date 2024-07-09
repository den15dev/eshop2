<div class="cart-item">
    <div class="cart-item_number">{{ $num }}</div>

    <a href="{{ $sku->url }}" class="cart-item_image-link">
        <img src="{{ $sku->getImageURL('sm') }}" alt="{{ $sku->name }}">
        <div class="image-link-tint"></div>
    </a>

    <div class="flex-wrap-separator"></div>

    <div class="cart-item_details">
        <a href="{{ $sku->url }}" class="cart-item_name dark-link">
            {{ $sku->name }}
        </a>
        <div class="cart-item_short-descr small">
            {{ $sku->short_descr }}
        </div>

        <x-cart-item-price :sku="$sku" />
    </div>

    <x-cart-item-price type="mobile" :sku="$sku" />

    <div class="cart-item_qty-sum-cont">
        <x-quantity-btns :skuid="$sku->id" :incart="$sku->in_cart" :twosizes="true" />

        <div class="cart-item_sum">
            @if($sku->discount)
                <div class="product-card_old-price">
                    <del>{!! $sku->cost_formatted !!}</del>
                </div>
            @endif
            <div class="product-card_price">{!! $sku->final_cost_formatted !!}</div>
        </div>
    </div>

    <div class="cart-item_btns">
        <div class="btn-icon" role="button" data-id="{{ $sku->id }}" title="{{ __('cart.remove_item') }}">
            <span class="icon-x-lg"></span>
        </div>
    </div>
</div>