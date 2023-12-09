<div class="bottom-menu_cont px-25 py-0" id="bottomNavFiltersCont">
    <div class="bottom-menu_close-btn" style="right: 26px">
        <svg><use href="#closeIcon" /></svg>
    </div>

    <form method="GET" action="" class="bottom-nav_filters-form" id="filterFormMobile">
        <div class="bottom-nav_filters-cont">
            <x-catalog-filters-dropdown type="price"
                                        title="Цена"
                                        :data="$price_range"
                                        collapsed="off"
                                        :ismobile="true" />

            <x-catalog-filters-dropdown type="brands"
                                        title="Бренды"
                                        :data="$brands"
                                        collapsed="off"
                                        :ismobile="true" />

            @foreach($filter_specs as $spec)
                <x-catalog-filters-dropdown type="specs"
                                            title="{{ $spec->name }}"
                                            :data="$spec"
                                            collapsed="on"
                                            :ismobile="true" />
            @endforeach
        </div>

        <div class="catalog-filters_btn-cont">
            <button type="submit">{{ __('catalog.filters.apply') }}</button>
            <a href="#" class="btn btn-bg-grey">{{ __('catalog.filters.reset') }}</a>
        </div>
    </form>
</div>