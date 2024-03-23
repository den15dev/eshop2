<div class="search-dropdown_cont-inner scrollbar-thin">
    @if($total->brands)
        <div class="search-dropdown_count-cont">
            <span class="fw-bold">{{ __('search.brands') }}</span>
            <span class="lightgrey-text">({{ $total->brands }})</span>
        </div>

        <div class="mb-2 mt-1">
            @foreach($brands as $brand)
                <a href="{{ $brand->url }}" class="search-dropdown_brand-item">{{ $brand->name }}</a>
            @endforeach
        </div>
    @endif

    @if($total->skus)
        <div class="search-dropdown_count-cont">
            <a href="{{ route('search', ['query' => $search_query]) }}" class="dark-link">
                <span class="fw-bold">{{ __('search.products') }}</span>
                <span class="lightgrey-text">({{ $total->skus }})</span>
            </a>
        </div>

        @foreach($products as $product)
            <x-search-dropdown-item :product="$product" />
        @endforeach
    @endif

    @if(!$total->brands && !$total->skus)
        <div class="search-dropdown_not-found-cont">
            {{ __('search.nothings_found') }}
        </div>
    @endif
</div>