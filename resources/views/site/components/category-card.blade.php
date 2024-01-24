<div class="category-card">
    @if($category->level < 3 || $category->product_count)
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

            @if($category->product_count)
                <div class="category-card_product-count">
                    {{ trans_choice('catalog.product_num', $category->product_count) }}
                </div>
            @endif
        </div>
    @else
        <div class="category-card_image-empty">
            <img src="{{ asset('storage/images/products/4/01_230.jpg') }}" class="product-card_image" alt="{{ $category->name }}">
        </div>

        <div class="category-card_title-cont">
            <div class="category-card_title-empty">{{ $category->name }}</div>
        </div>
    @endif
</div>