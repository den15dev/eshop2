<a href="{{ $sku->url }}" class="search-dropdown_item">
    <img src="{{ $sku->getImage('tn') }}">
    <div class="product-title">
        {{ $sku->name }}
    </div>
    <div class="product-price">
        {!! $sku->final_price_formatted !!}
    </div>
</a>