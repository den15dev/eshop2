<div class="bottom-nav">
    <div class="bottom-nav_cont">
        <a href="#" class="bottom-nav-btn">
            <svg viewBox="0 0 21 19">
                <use href="#favoriteIcon"/>
            </svg>
            {{ __('header.user_menu.favorites') }}
            {{--            <div class="badge-round">2</div>--}}
        </a>
        <a href="#" class="bottom-nav-btn">
            <svg viewBox="0 0 22 22">
                <use href="#cartIcon"/>
            </svg>
            {{ __('header.user_menu.cart') }}
            {{--            <div class="badge-round-red">2</div>--}}
        </a>
        <div class="bottom-nav-btn" style="padding-top: 12px;" id="bottomNavMenuBtn">
            <svg viewBox="0 0 15 14" style="height: 28px;">
                <use href="#listIcon"/>
            </svg>
        </div>

        @if(request()->routeIs('catalog'))
            <div class="bottom-nav-btn" id="bottomNavFiltersBtn">
                <svg viewBox="0 0 23 22">
                    <use href="#filtersIcon"/>
                </svg>
                {{ __('header.user_menu.filters') }}
            </div>
        @else
            <a href="#" class="bottom-nav-btn">
                <svg viewBox="0 0 17 21">
                    <use href="#ordersIcon"/>
                </svg>
                {{ __('header.user_menu.orders') }}
            </a>
        @endif

        @guest
        <div class="bottom-nav-btn" id="bnavSignInBtn">
            <svg viewBox="0 0 16 20"><use href="#lockIcon" /></svg>
            {{ __('header.user_menu.sign_in') }}
        </div>
        @elseauth
        <div class="bottom-nav-user-btn" id="bottomNavProfileBtn">
            @if(Auth::user()->thumbnail)
                <img src="{{ asset('storage/images/users/' . Auth::user()->thumbnail) }}" alt="">
            @else
                <svg viewBox="0 0 38 38">
                    <path d="M38 0H0V38H38V0Z" id="bNavUserIconBG"/>
                    <path d="M19 21.432C23.4492 21.432 27.056 17.8252 27.056 13.376C27.056 8.9268 23.4492 5.32001 19 5.32001C14.5508 5.32001 10.944 8.9268 10.944 13.376C10.944 17.8252 14.5508 21.432 19 21.432Z" id="bNavUserIconHead"/>
                    <path d="M34.8967 38C34.8967 32.1923 33.1233 23.7943 24.9913 21.736C21.5017 24.3833 16.1817 24.225 13.015 21.736C4.87667 23.7943 3.10333 32.1923 3.10333 38C6.65 38 31.35 38 34.8967 38Z" id="bNavUserIconBody"/>
                </svg>
            @endif
        </div>
        @endguest
    </div>

    @include('site.main.bottom-nav.bottom-nav-menu')

    @if(request()->routeIs('catalog'))
        @include('site.main.bottom-nav.bottom-nav-filters')
    @endif

    @include('site.main.bottom-nav.bottom-nav-profile')
</div>