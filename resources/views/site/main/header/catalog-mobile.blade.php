<div class="container px-0 scrollbar-thin" id="catalogNavMobile">
    <ul class="catalog-mobile-list">

        @foreach($categories as $category)
            <li>
                <div class="cat-btn1">
                    <div class="cat-icon-cont">
                        <svg viewBox="{{ $catalog_icons[$category['slug']]['viewbox'] }}" style="height: {{ $catalog_icons[$category['slug']]['height_prc'] }}%">
                            <use href="#catalogIcon_{{ $category['slug'] }}"/>
                        </svg>
                    </div>
                    <span class="cat-btn1-text">{{ $category['name'] }}</span>
                </div>
                <ul class="catalog-mobile-sublist">
                    @foreach($category['subcategories'] as $subcat2)
                        <li>
                            <div class="cat-btn2">
                                {{ $subcat2['name'] }}<span class="icon-chevron icon-chevron-right"></span>
                            </div>
                            <ul class="catalog-mobile-sublist">
                                @foreach($subcat2['subcategories'] as $subcat3)
                                    @if(isset($subcat3['subcategories']))

                                        <li>
                                            <div class="cat-btn2">
                                                {{ $subcat3['name'] }}&nbsp;@if($subcat3['product_count'])<span class="cat-count">{{ $subcat3['product_count'] }}</span>@endif<span class="icon-chevron icon-chevron-right"></span>
                                            </div>
                                            <ul class="catalog-mobile-sublist">
                                                @foreach($subcat3['subcategories'] as $subcat4)
                                                    <li>
                                                        <a href="{{ route('catalog', $subcat4['slug']) }}" class="cat-btn2">
                                                            {{ $subcat4['name'] }}&nbsp;@if($subcat4['product_count'])<span class="cat-count">{{ $subcat4['product_count'] }}</span>@endif
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>

                                    @else
                                        <li>
                                            <a href="{{ route('catalog', $subcat3['slug']) }}" class="cat-btn2">
                                                {{ $subcat3['name'] }}&nbsp;@if($subcat3['product_count'])<span class="cat-count">{{ $subcat3['product_count'] }}</span>@endif
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>

                    @endforeach
                </ul>
            </li>
        @endforeach

    </ul>
</div>