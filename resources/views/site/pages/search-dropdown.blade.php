<div class="search-dropdown_cont-inner scrollbar-thin">
    @if($brands->count())
        <div class="search-dropdown_count-cont">
            <span class="fw-bold">{{ __('search.brands') }}</span>
            <span class="lightgrey-text">({{ $brands->count() }})</span>
        </div>

        <div class="mb-2 mt-1">
            @foreach($brands as $brand)
                <a href="{{ $brand->url }}" class="search-dropdown_brand-item">{{ $brand->name }}</a>
            @endforeach
        </div>
    @endif

    @if($total_products)
        <div class="search-dropdown_count-cont">
            <a href="{{ route('search.dropdown', ['query' => $search_query]) }}" class="dark-link">
                <span class="fw-bold">{{ __('search.products') }}</span>
                <span class="lightgrey-text">({{ $total_products }})</span>
            </a>
        </div>

        @foreach($products as $product)
            <x-search-dropdown-item :product="$product" />
        @endforeach
    @endif

    @if(!$brands->count() && !$total_products)
        <div class="search-dropdown_not-found-cont">
            {{ __('search.nothings_found') }}
        </div>
    @endif
</div>