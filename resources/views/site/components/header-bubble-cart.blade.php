<div class="header-bubble" id="cartHeaderBubble">
    <div class="header-bubble_close-btn"><span class="icon-x"></span></div>
    <div class="cart-header-bubble_label mb-3">{{ __('cart.header_bubble.added') }}:</div>
    <div class="cart-header-bubble_item mb-3">
        <a href="#" class="cart-header-bubble_img-link">
            <img src="" alt="">
        </a>
        <div class="cart-header-bubble_title">
            <a href="#" class="dark-link"></a>
        </div>
        <div class="cart-header-bubble_qty"></div>
    </div>
    <a href="{{ route('cart') }}" class="btn btn-bg-red cart-header-bubble_btn">{{ __('cart.header_bubble.go_to_cart') }}</a>
</div>