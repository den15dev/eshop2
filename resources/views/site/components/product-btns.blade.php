<div class="product-btn-cont{{ isset($size) && $size === 'small' ? ' small' : '' }}{{ isset($mb) ? ' mb-' . $mb : '' }}{{ isset($layout) && $layout === 'row' ? ' btns-row' : '' }}">
    <div class="product-compare-btn" data-id="{{ $id }}">
        <span class="icon-bar-chart"></span>
        {{ __('catalog.product_card.compare') }}
    </div>
    <div class="product-favorite-btn" data-id="{{ $id }}">
        <span class="icon-heart"></span>
        {{ __('catalog.product_card.add_to_fav') }}
    </div>
</div>