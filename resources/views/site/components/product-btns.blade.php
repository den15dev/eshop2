<div class="product-btn-cont{{ isset($size) && $size === 'small' ? ' small' : '' }}{{ isset($mb) ? ' mb-' . $mb : '' }}">
    <div class="product-compare-btn" data-id="{{ $id }}">
        <span class="icon-bar-chart me-1"></span>
        {{ __('catalog.product_card.compare') }}
    </div>
    <div class="product-favorite-btn" data-id="{{ $id }}">
        <span class="icon-heart me-1"></span>
        {{ __('catalog.product_card.add_to_fav') }}
    </div>
</div>