<div class="category-card">
    @if($category->sku_num_children)
        <div class="product-card_image-cont">
            <a href="{{ route('catalog', $category->slug) }}" class="product-card_image-link">
                <img src="{{ get_image('storage/images/categories/' . $category->slug . '.jpg', 230) }}" class="product-card_image" alt="{{ $category->name }}">
                <div class="image-link-tint"></div>
            </a>
        </div>

        <div class="category-card_title-cont">
            <a href="{{ route('catalog', $category->slug) }}" class="category-card_title">
                {{ $category->name }}
            </a>

            <div class="category-card_product-count">
                {{ trans_choice('catalog.product_num', $category->sku_num_children) }}
            </div>
        </div>
    @else
        <div class="category-card_image-empty">
            <img src="{{ get_image('storage/images/categories/' . $category->slug . '.jpg', 230) }}" class="product-card_image" alt="{{ $category->name }}">
        </div>

        <div class="category-card_title-cont">
            <div class="category-card_title-empty">{{ $category->name }}</div>
            <div class="category-card_product-count empty">{{ __('catalog.no_products') }}</div>
        </div>
    @endif
</div>