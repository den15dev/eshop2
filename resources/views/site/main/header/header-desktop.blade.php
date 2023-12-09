<div class="container" id="desktopHeader">
    <div class="header-logo">
        <a href="{{ route('home') }}" class="logo logo-{{ app()->getLocale() === 'ru' ? 'ru' : 'en' }}">
            <svg viewBox="0 0 20 28">
                <use href="#logoSign"/>
            </svg>
            @if(app()->getLocale() === 'ru')
                <svg viewBox="0 0 155 26">
                    <use href="#logoTitleRu"/>
                </svg>
            @else
                <svg viewBox="0 0 138 26">
                    <use href="#logoTitleEn"/>
                </svg>
            @endif
        </a>
    </div>
    <nav class="top-center">
        <ul class="nav-list-top">
            <li>
                <a href="#">
                    {{ __('header.top_menu.delivery') }}
                </a>
            </li>
            <li>
                <a href="#">
                    {{ __('header.top_menu.shops') }}
                </a>
            </li>
            <li>
                <a href="#">
                    {{ __('header.top_menu.warranty') }}
                </a>
            </li>
            <li class="dropdown">
                <div class="dropdown-btn">
                    {{ __('header.top_menu.for_customers') }}
                    <span class="icon-chevron-down xsmall"></span>
                </div>
                <ul class="dropdown-list">
                    <li>
                        <a href="#">
                            {{ __('header.top_menu.bonuses') }}
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            {{ __('header.top_menu.return') }}
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            {{ __('header.top_menu.service') }}
                        </a>
                    </li>
                </ul>
            </li>
            <li class="tel">
                <a href="tel:{{ $phone_tel }}">
                    <svg>
                        <use href="#telIcon"/>
                    </svg>
                    {{ $phone }}
                </a>
            </li>
        </ul>
    </nav>
    <div class="top-right">
        <x-languages-dropdown type="desktop" :languages="$languages" :curlang="$languages->first()" />
    </div>


    <div class="bottom-left">
        <div class="btn catalog-btn" role="button" id="catalogBtnDesktop">
            <div class="catalog-btn_title">
                {{ __('header.catalog') }}
            </div>
            <div class="catalog-btn_icon">
                <svg class="svg-catalog-list">
                    <use href="#listIcon"/>
                </svg>
                <svg class="svg-close">
                    <use href="#closeIcon"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bottom-center">
        <form class="search-form" method="GET" action="">
            <div class="search_results_cont" id="searchResultCont"></div>
            <input class="search-input bordered" name="query" placeholder="{{ __('header.search.search') }}" autocomplete="off" id="searchInput">
            <span class="btn-icon clear-btn icon-x-lg" id="clearBtn"></span>

            <button class="btn-icon search-btn" type="submit">
                <svg>
                    <use href="#searchIcon"/>
                </svg>
            </button>
        </form>
    </div>

    <nav class="bottom-right">
        <ul class="nav-list-user">
            <li>
                <a href="#">
                    <svg viewBox="0 0 21 19">
                        <use href="#favoriteIcon"/>
                    </svg>
                    {{ __('header.user_menu.favorites') }}
                    <div class="badge-round">2</div>
                </a>
            </li>
            <li>
                <a href="#">
                    <svg viewBox="0 0 22 22">
                        <use href="#cartIcon"/>
                    </svg>
                    {{ __('header.user_menu.cart') }}
                    <div class="badge-round-red">3</div>
                </a>
            </li>
            <li>
                <a href="#">
                    <svg viewBox="0 0 17 21">
                        <use href="#ordersIcon"/>
                    </svg>
                    {{ __('header.user_menu.orders') }}
                </a>
            </li>
            {{--<li>
                <a href="#">
                    <svg viewBox="0 0 16 20">
                        <use href="#lockIcon"/>
                    </svg>
                    {{ __('header.user_menu.login') }}
                </a>
            </li>--}}
            {{--<li>
                <a href="#">
                    <svg viewBox="0 0 18 21"><use href="#userIcon" /></svg>
                    <span style="margin-left: -2px">Регистрация</span>
                </a>
            </li>--}}
            <li class="dropdown">
                <div class="dropdown-btn">
                    <svg viewBox="0 0 18 21">
                        <use href="#userIcon"/>
                    </svg>
                    <span>{{ __('header.user_menu.profile') }}</span>
                </div>
                <ul class="dropdown-list dd-right">
                    <li>
                        <a href="#">
                            <span class="icon-key me-2"></span>
                            {{ __('header.user_menu.profile_menu.admin_panel') }}
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon-gear me-2"></span>
                            {{ __('header.user_menu.profile_menu.settings') }}
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon-bell me-2"></span>
                            {{ __('header.user_menu.profile_menu.notifications') }}
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <span class="icon-box-arrow-right me-2"></span>
                            {{ __('header.user_menu.profile_menu.logout') }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>