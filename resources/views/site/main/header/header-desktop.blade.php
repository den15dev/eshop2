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
        <x-currencies-dropdown type="desktop" :currencies="$currencies" :curcurr="$currencies->first()" />
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
                <a href="{{ route('favorites') }}" class="outline-btn">
                    <svg viewBox="0 0 21 19">
                        <use href="#favoriteIcon"/>
                    </svg>
                    {{ __('header.user_menu.favorites') }}
                    <div class="badge-round">2</div>
                </a>
            </li>
            <li>
                <a href="{{ route('cart') }}" class="outline-btn">
                    <svg viewBox="0 0 22 22">
                        <use href="#cartIcon"/>
                    </svg>
                    {{ __('header.user_menu.cart') }}
                    <div class="badge-round-red">3</div>
                </a>
            </li>
            <li>
                <a href="{{ route('orders') }}" class="outline-btn">
                    <svg viewBox="0 0 17 21">
                        <use href="#ordersIcon"/>
                    </svg>
                    {{ __('header.user_menu.orders') }}
                </a>
            </li>
            @guest
            <li>
                <div class="outline-btn" id="headerSignInBtn">
                    <svg viewBox="0 0 16 20">
                        <use href="#lockIcon"/>
                    </svg>
                    {{ __('header.user_menu.sign_in') }}
                </div>
            </li>
            @elseauth
            <li class="dropdown">
                <div class="dropdown-btn user-btn">
                    @if(Auth::user()->thumbnail)
                        <img src="{{ asset('storage/images/users/' . Auth::user()->thumbnail) }}" alt="">
                    @else
                        <svg viewBox="0 0 38 38">
                            <path d="M38 0H0V38H38V0Z" id="userIconBG"/>
                            <path d="M19 21.432C23.4492 21.432 27.056 17.8252 27.056 13.376C27.056 8.9268 23.4492 5.32001 19 5.32001C14.5508 5.32001 10.944 8.9268 10.944 13.376C10.944 17.8252 14.5508 21.432 19 21.432Z" id="userIconHead"/>
                            <path d="M34.8967 38C34.8967 32.1923 33.1233 23.7943 24.9913 21.736C21.5017 24.3833 16.1817 24.225 13.015 21.736C4.87667 23.7943 3.10333 32.1923 3.10333 38C6.65 38 31.35 38 34.8967 38Z" id="userIconBody"/>
                        </svg>
                    @endif
                </div>
                <ul class="dropdown-list dd-right">
                    <li>
                        <div class="user-dd-name">
                            {{ Auth::user()->name }}
                        </div>
                    </li>
                    @if(Auth::user()->isAdmin())
                    <li>
                        <a href="#" class="user-dd-btn">
                            <span class="icon-key me-1"></span>
                            {{ __('header.user_menu.profile_menu.admin_panel') }}
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="#" class="user-dd-btn">
                            <span class="icon-gear me-1"></span>
                            {{ __('header.user_menu.profile_menu.settings') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" class="user-dd-btn">
                            <span class="icon-bell me-1"></span>
                            {{ __('header.user_menu.profile_menu.notifications') }}
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <div class="user-dd-btn" id="headerLogoutBtn">
                                <span class="icon-box-arrow-right me-1"></span>
                                {{ __('header.user_menu.profile_menu.logout') }}
                            </div>
                        </form>
                    </li>
                </ul>
            </li>
            @endguest
        </ul>
    </nav>
</div>