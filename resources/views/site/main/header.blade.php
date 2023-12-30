<header>
    @include('site.main.header.header-desktop')

    @include('site.main.header.header-mobile')

    <div class="catalog-nav-cont" id="catalogNavCont">
        @include('site.main.header.catalog-desktop')

        @include('site.main.header.catalog-mobile')
    </div>

    <div class="search-mobile-cont" id="searchMobileCont">
        <div class="container">
            <form class="search-form" method="GET" action="">
                <input class="search-input-mobile" name="query" placeholder="{{ __('header.search.search') }}" autocomplete="off"
                       id="searchInputMobile">
                <span class="btn-icon clear-btn icon-x-lg" id="clearBtnMobile"></span>
                <button class="btn-icon search-btn" type="submit">
                    <svg>
                        <use href="#searchIcon"/>
                    </svg>
                </button>
            </form>
        </div>

        <div id="searchResultContMobile"></div>
    </div>

    <form method="POST" action="{{ route('language') }}" id="changeLanguageForm" style="display: none">
        @csrf
        <input type="hidden" name="new_language" value="" />
    </form>
    <form method="POST" action="{{ route('currency') }}" id="changeCurrencyForm" style="display: none">
        @csrf
        <input type="hidden" name="new_currency" value="" />
    </form>
</header>

<div class="shadow-toggler"></div>

<script>
    const header = document.querySelector('header');
    const shadowToggler = document.querySelector('.shadow-toggler');
    const observer = new IntersectionObserver(([entry]) => {
        header.classList.toggle('header-shadow', !entry.isIntersecting);
    });
    observer.observe(shadowToggler);
</script>