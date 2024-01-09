<div class="container" id="catalogNavDesktop">
    <ul class="catalog-desktop-root-list">
        @foreach($categories as $category)
            <li {!! $loop->first ? 'class="active"' : '' !!} data-id="{{ $category['id'] }}">
                <div class="icon-cont">
                    <svg viewBox="{{ $catalog_icons[$category['slug']]['viewbox'] }}" style="height: {{ $catalog_icons[$category['slug']]['height_prc'] }}%">
                        <use href="#catalogIcon_{{ $category['slug'] }}"/>
                    </svg>
                </div>
                <span class="item-text">{{ $category['name'] }}</span>
            </li>
        @endforeach
    </ul>

    @foreach($categories as $category)
        <div class="catalog-desktop-body-cont" data-id="{{ $category['id'] }}" {!! $loop->first ? 'data-opened="on" style="display: block"' : '' !!}>

            @foreach($category['subcategories'] as $subcat2)
                <section>
                    <h6>{{ $subcat2['name'] }}</h6>
                    <ul>
                        @foreach($subcat2['subcategories'] as $subcat3)

                            @if(isset($subcat3['subcategories']))
                                <li class="dropdown-hover">
                                    <div class="dropdown-btn">
                                        {{ $subcat3['name'] }}&nbsp;@if($subcat3['product_count'])<span class="cat-count">{{ $subcat3['product_count'] }}</span>@endif<span class="icon-chevron-right xsmall ms-1"></span>
                                    </div>
                                    <ul class="dropdown-list dd-right-out">
                                        @foreach($subcat3['subcategories'] as $subcat4)
                                            <li>
                                                <a href="{{ route('catalog', $subcat4['slug']) }}">
                                                    {{ $subcat4['name'] }}&nbsp;@if($subcat4['product_count'])<span class="cat-count">{{ $subcat4['product_count'] }}</span>@endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('catalog', $subcat3['slug']) }}">
                                        {{ $subcat3['name'] }}&nbsp;@if($subcat3['product_count'])<span class="cat-count">{{ $subcat3['product_count'] }}</span>@endif
                                    </a>
                                </li>
                            @endif

                        @endforeach
                    </ul>
                </section>
            @endforeach

        </div>
    @endforeach
</div>