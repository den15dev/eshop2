<header>
    <div class="container" id="mobileHeader">
        <div class="btn-icon header-mobile_menu-btn" id="headerMobileLeftBtn">
            <svg class="header-mobile_open-icon"><use href="#chevronDownIcon"/></svg>
            <svg class="header-mobile_close-icon"><use href="#closeIcon"/></svg>
        </div>
        <div class="header-mobile_logo-cont">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('img/logo/logo_en_160.png') }}" alt="{{ __('general.app_name') }}">
            </a>
            <div class="header-mobile_logo-subtitle">{{ __('admin/layout.admin_panel') }}</div>
        </div>
        <div class="btn-icon header-mobile_menu-btn" id="headerMobileRightBtn">
            <svg class="header-mobile_open-icon"><use href="#listIcon"/></svg>
            <svg class="header-mobile_close-icon"><use href="#closeIcon"/></svg>
        </div>
    </div>


    <div class="header-opener" id="headerLeftMenuCont">
        <div class="container pb-2">
            @include('admin.main.navigation')
        </div>
    </div>

    <div class="header-opener" id="headerRightMenuCont">
        <div class="container pb-2">
            <ul class="header-mobile_right-menu-list">
                <li>
                    <x-languages-dropdown type="mobile" :languages="$languages" :curlang="$languages->first()" />
                </li>
                <li>
                    <a href="{{ route('home') }}" class="header-desktop_site-link grey-link">{{ __('admin/layout.go_to_site') }}</a>
                </li>
            </ul>
        </div>
    </div>


    <form method="POST" action="{{ route('language.set') }}" id="changeLanguageForm" style="display: none">
        @csrf
        <input type="hidden" name="new_language" value=""/>
    </form>
</header>

<div class="shadow-toggler"></div>

<script>
    const header = document.querySelector('#mobileHeader');
    const shadowToggler = document.querySelector('.shadow-toggler');
    const observer = new IntersectionObserver(([entry]) => {
        header.classList.toggle('header-shadow', !entry.isIntersecting);
    });
    observer.observe(shadowToggler);
</script>