<div class="container" id="mobileHeader">
    <button class="btn catalog-btn-mobile" id="catalogBtnMobile">
        <svg class="svg-chevron-down">
            <use href="#catalogChevronDown"/>
        </svg>
        <svg class="svg-close">
            <use href="#closeIcon"/>
        </svg>
    </button>
    <div class="header-logo-mobile">
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
    <button class="btn-icon search-btn-mobile-nav" id="searchBtnMobileNav">
        <svg class="svg-search">
            <use href="#searchIcon"/>
        </svg>
        <svg class="svg-close">
            <use href="#closeIcon"/>
        </svg>
    </button>
</div>