<a href="{{ $product->url }}" class="search-dropdown_item">
    <img src="{{ $product->image_sm }}">
    <div class="product-title">
        {{ $product->name }}
    </div>
    <div class="product-price">
        {!! $product->final_price_formatted !!}
    </div>
</a>