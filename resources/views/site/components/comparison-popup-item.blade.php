<div class="comparison-popup_item" data-id="{{ $sku->id }}">
    <a href="{{ $sku->url }}" class="comparison-popup_item-img-link">
        <img src="{{ $sku->getImageURL('tn') }}" alt="{{ $sku->name }}">
    </a>
    <a href="{{ $sku->url }}" class="comparison-popup_item-name-link dark-link">
        {{ $sku->name }}
    </a>
    <div class="btn-link" title="{{ __('comparison.remove_title') }}">
        <span class="icon-x-lg"></span>
    </div>
</div>