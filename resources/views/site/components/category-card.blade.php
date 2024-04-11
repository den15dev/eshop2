<div class="category-card">
    @if($skunum)
        <div class="product-card_image-cont">
            <a href="{{ route('catalog', $category->slug) }}" class="product-card_image-link">
                <img src="{{ $category->image_md }}" class="product-card_image" alt="{{ $category->name }}">
                <div class="image-link-tint"></div>
            </a>
        </div>

        <div class="category-card_title-cont">
            <a href="{{ route('catalog', $category->slug) }}" class="category-card_title">
                {{ $category->name }}
            </a>

            <div class="category-card_product-count">
                {{ trans_choice('catalog.product_num', $skunum) }}
            </div>
        </div>
    @else
        <div class="category-card_image-empty">
            <img src="{{ $category->image_md }}" class="product-card_image" alt="{{ $category->name }}">
        </div>

        <div class="category-card_title-cont">
            <div class="category-card_title-empty">{{ $category->name }}</div>
            <div class="category-card_product-count empty">{{ __('catalog.no_products') }}</div>
        </div>
    @endif
</div>