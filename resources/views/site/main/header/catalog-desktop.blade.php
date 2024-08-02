<div class="container" id="catalogNavDesktop">
    <ul class="catalog-desktop-root-list">
        @foreach($categories as $category)
            <li {!! $loop->first ? 'class="active"' : '' !!} data-id="{{ $category['id'] }}">
                <svg viewBox="0 0 24 24" class="icon-cont root-category-icon">
                    <use href="#catalogIcon_{{ $category['slug'] }}"/>
                </svg>
                <span class="item-text">{{ $category['name'] }}</span>
            </li>
        @endforeach
    </ul>

    @foreach($categories as $category)
        <div class="catalog-desktop-body-cont" data-id="{{ $category['id'] }}" {!! $loop->first ? 'data-opened="on" style="display: block"' : '' !!}>

            @isset($category['subcategories'])
                @foreach($category['subcategories'] as $subcat2)
                    <section>
                        <h6>
                            <a href="{{ route('catalog', $subcat2['slug']) }}" class="dark-link">{{ $subcat2['name'] }}</a>
                        </h6>
                        <ul>
                            @isset($subcat2['subcategories'])
                                @foreach($subcat2['subcategories'] as $subcat3)

                                    @if(isset($subcat3['subcategories']))
                                        <li class="dropdown-hover">
                                            @if($subcat3['product_count'])
                                                <a href="{{ route('catalog', $subcat3['slug']) }}" class="dropdown-btn section-item">
                                                    {{ $subcat3['name'] }}&nbsp;<span class="product-count">{{ $subcat3['product_count'] }}</span><span class="icon-chevron-right xsmall ms-1"></span>
                                                </a>
                                            @else
                                                <div class="dropdown-btn section-item inactive">
                                                    {{ $subcat3['name'] }}<span class="icon-chevron-right xsmall ms-1"></span>
                                                </div>
                                            @endif
                                            <ul class="dropdown-list dd-right-out">
                                                @foreach($subcat3['subcategories'] as $subcat4)
                                                    <li>
                                                        @if($subcat4['product_count'])
                                                            <a href="{{ route('catalog', $subcat4['slug']) }}" class="dropdown-item section-item">
                                                                {{ $subcat4['name'] }}&nbsp;<span class="product-count">{{ $subcat4['product_count'] }}</span>
                                                            </a>
                                                        @else
                                                            <div class="dropdown-item section-item inactive">
                                                                {{ $subcat4['name'] }}
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li>
                                            @if($subcat3['product_count'])
                                                <a href="{{ route('catalog', $subcat3['slug']) }}" class="section-item">
                                                    {{ $subcat3['name'] }}&nbsp;<span class="product-count">{{ $subcat3['product_count'] }}</span>
                                                </a>
                                            @else
                                                <div class="section-item inactive">
                                                    {{ $subcat3['name'] }}
                                                </div>
                                            @endif
                                        </li>
                                    @endif

                                @endforeach
                            @endisset
                        </ul>
                    </section>
                @endforeach
            @endisset

        </div>
    @endforeach
</div>