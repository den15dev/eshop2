<div class="bottom-menu_cont px-25 py-0" id="bottomNavFiltersCont">
    <div class="bottom-menu_close-btn" style="right: 26px">
        <svg><use href="#closeIcon" /></svg>
    </div>

    <form method="GET" action="" id="filterFormMobile">
        @include('site.pages.' . $filters . '-filters')

        <div class="filters_btn-cont">
            <button type="submit">{{ __('catalog.filters.apply') }}</button>
            <a href="{{ route('catalog', $category->slug) }}" class="btn btn-bg-grey">{{ __('catalog.filters.reset') }}</a>
        </div>
    </form>
</div>