<div class="comparison-popup_item" data-id="{{ $product->id }}">
    <a href="{{ $product->url }}" class="comparison-popup_item-img-link">
        <img src="{{ asset('storage/images/products/' . (($product->id - 1) % 4 + 1) . '/01_80.jpg') }}" alt="{{ $product->name }}">
    </a>
    <a href="{{ $product->url }}" class="comparison-popup_item-name-link dark-link">
        {{ $product->name }}
    </a>
    <div class="btn-link" title="{{ __('comparison.remove_title') }}">
        <span class="icon-x-lg"></span>
    </div>
</div>