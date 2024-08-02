<div class="container px-0 scrollbar-thin" id="catalogNavMobile">
    <ul class="catalog-mobile-menu">
        @foreach($categories as $category)
        <li>
            <div class="catalog-mobile-menu_root-btn">
                <svg viewBox="0 0 24 24" class="catalog-mobile-menu_icon root-category-icon">
                    <use href="#catalogIcon_{{ $category['slug'] }}"/>
                </svg>
                <div class="catalog-mobile-menu_root-btn_text">{{ $category['name'] }}</div>
            </div>

            @isset($category['subcategories'])
                <ul class="catalog-mobile-menu_sublist">
                    @foreach($category['subcategories'] as $subcat2)
                        <li>
                            <div class="catalog-mobile-menu_sub-btn level2">
                                {{ $subcat2['name'] }}&nbsp;<span class="icon-chevron icon-chevron-right"></span>
                            </div>

                            @isset($subcat2['subcategories'])
                                <ul class="catalog-mobile-menu_sublist">
                                    @foreach($subcat2['subcategories'] as $subcat3)
                                        @if(isset($subcat3['subcategories']))

                                            <li>
                                                @if($subcat3['product_count'])
                                                    <div class="catalog-mobile-menu_sub-btn level3">
                                                        {{ $subcat3['name'] }}&nbsp;<span class="sku-count">{{ $subcat3['product_count'] }}</span><span class="icon-chevron icon-chevron-right"></span>
                                                    </div>
                                                @else
                                                    <div class="catalog-mobile-menu_sub-btn level3 empty">
                                                        {{ $subcat3['name'] }}&nbsp;<span class="icon-chevron icon-chevron-right"></span>
                                                    </div>
                                                @endif
                                                <ul class="catalog-mobile-menu_sublist">
                                                    @foreach($subcat3['subcategories'] as $subcat4)
                                                        <li>
                                                            @if($subcat4['product_count'])
                                                                <a href="{{ route('catalog', $subcat4['slug']) }}" class="catalog-mobile-menu_sub-btn level4">
                                                                    {{ $subcat4['name'] }}&nbsp;<span class="sku-count">{{ $subcat4['product_count'] }}</span>
                                                                </a>
                                                            @else
                                                                <div class="catalog-mobile-menu_sub-btn level4 empty">
                                                                    {{ $subcat4['name'] }}&nbsp;
                                                                </div>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>

                                        @else
                                            <li>
                                                @if($subcat3['product_count'])
                                                    <a href="{{ route('catalog', $subcat3['slug']) }}" class="catalog-mobile-menu_sub-btn level3">
                                                        {{ $subcat3['name'] }}&nbsp;<span class="sku-count">{{ $subcat3['product_count'] }}</span>
                                                    </a>
                                                @else
                                                    <div class="catalog-mobile-menu_sub-btn level3 empty">
                                                        {{ $subcat3['name'] }}&nbsp;
                                                    </div>
                                                @endif
                                            </li>
                                         @endif
                                    @endforeach
                                </ul>
                            @endisset

                        </li>
                    @endforeach
                </ul>
            @endisset

        </li>
        @endforeach
    </ul>
</div>