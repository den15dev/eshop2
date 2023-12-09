<div class="bottom-nav">
    <div class="bottom-nav_cont">
        <a href="#">
            <svg viewBox="0 0 21 19">
                <use href="#favoriteIcon"/>
            </svg>
            {{ __('header.user_menu.favorites') }}
            {{--            <div class="badge-round">2</div>--}}
        </a>
        <a href="#">
            <svg viewBox="0 0 22 22">
                <use href="#cartIcon"/>
            </svg>
            {{ __('header.user_menu.cart') }}
            {{--            <div class="badge-round-red">2</div>--}}
        </a>
        <div style="padding-top: 12px;" id="bottomNavMenuBtn">
            <svg viewBox="0 0 15 14" style="height: 28px;">
                <use href="#listIcon"/>
            </svg>
        </div>

        @if(request()->routeIs('catalog'))
            <div id="bottomNavFiltersBtn">
                <svg viewBox="0 0 23 22">
                    <use href="#filtersIcon"/>
                </svg>
                {{ __('header.user_menu.filters') }}
            </div>
        @else
            <a href="#">
                <svg viewBox="0 0 17 21">
                    <use href="#ordersIcon"/>
                </svg>
                {{ __('header.user_menu.orders') }}
            </a>
        @endif

        {{--<a href="#">
                <svg viewBox="0 0 16 20"><use href="#lockIcon" /></svg>
                Вход
            </a>--}}
        {{--    <a href="#">
                <svg viewBox="0 0 18 21"><use href="#userIcon" /></svg>
                Регистрация
            </a>--}}
        <div id="bottomNavProfileBtn">
            <svg viewBox="0 0 18 21">
                <use href="#userIcon"/>
            </svg>
            {{ __('header.user_menu.profile') }}
        </div>
    </div>

    @include('site.main.bottom-nav.bottom-nav-menu')

    @if(request()->routeIs('catalog'))
        @include('site.main.bottom-nav.bottom-nav-filters')
    @endif

    @include('site.main.bottom-nav.bottom-nav-profile')
</div>