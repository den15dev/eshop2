<div class="container px-0 scrollbar-thin" id="catalogNavMobile">
    <ul class="catalog-mobile-list">

        @foreach($categories as $category)
            <li>
                <div class="cat-btn1">
                    <div class="cat-icon-cont">
                        <svg viewBox="0 0 24 24" class="catalog-category-icon">
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
                                            @if($subcat3['product_count'])
                                                <div class="cat-btn2">
                                                    {{ $subcat3['name'] }}&nbsp;<span class="cat-count">{{ $subcat3['product_count'] }}</span><span class="icon-chevron icon-chevron-right"></span>
                                                </div>
                                            @else
                                                <div class="cat-btn2 empty">
                                                    {{ $subcat3['name'] }}&nbsp;<span class="icon-chevron icon-chevron-right"></span>
                                                </div>
                                            @endif
                                            <ul class="catalog-mobile-sublist">
                                                @foreach($subcat3['subcategories'] as $subcat4)
                                                    <li>
                                                        @if($subcat4['product_count'])
                                                            <a href="{{ route('catalog', $subcat4['slug']) }}" class="cat-btn2">
                                                                {{ $subcat4['name'] }}&nbsp;<span class="cat-count">{{ $subcat4['product_count'] }}</span>
                                                            </a>
                                                        @else
                                                            <div class="cat-btn2 empty">
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
                                                <a href="{{ route('catalog', $subcat3['slug']) }}" class="cat-btn2">
                                                    {{ $subcat3['name'] }}&nbsp;<span class="cat-count">{{ $subcat3['product_count'] }}</span>
                                                </a>
                                            @else
                                                <div class="cat-btn2 empty">
                                                    {{ $subcat3['name'] }}&nbsp;
                                                </div>
                                            @endif
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