<footer>
    <div class="container footer-main-cont">
        <div class="footer-logo-cont">
            <a href="{{ route('home') }}" class="logo logo-{{ app()->getLocale() === 'ru' ? 'ru' : 'en' }}">
                <svg viewBox="0 0 20 28"><use href="#logoSign" /></svg>
                @if(app()->getLocale() === 'ru')
                    <svg viewBox="0 0 155 26"><use href="#logoTitleRu" /></svg>
                @else
                    <svg viewBox="0 0 138 26"><use href="#logoTitleEn"/></svg>
                @endif
            </a>
        </div>
        <div class="footer-col-cont">
            <div class="footer_section-title">{{ __('footer.company.title') }}</div>
            <ul class="footer-list">
                <li>
                    <div class="footer-list_link">{{ __('footer.company.about') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.company.news') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.company.for_partners') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.company.vacancies') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.company.privacy') }}</div>
                </li>
            </ul>
        </div>
        <div class="footer-col-cont">
            <div class="footer_section-title">{{ __('footer.for_buyers.title') }}</div>
            <ul class="footer-list">
                <li>
                    <div class="footer-list_link">{{ __('footer.for_buyers.make_order') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.for_buyers.payment_methods') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.for_buyers.credits') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.for_buyers.for_entities') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.for_buyers.corp_departments') }}</div>
                </li>
            </ul>
        </div>
        <div class="footer-col-cont">
            <div class="footer_section-title">{{ __('footer.other.title') }}</div>
            <ul class="footer-list">
                <li>
                    <div class="footer-list_link">{{ __('footer.other.delivery') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.other.return') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.other.gift_cards') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.other.bonus_program') }}</div>
                </li>
                <li>
                    <div class="footer-list_link">{{ __('footer.other.help') }}</div>
                </li>
            </ul>
        </div>
    </div>

    <div class="container footer-copyright-cont">
        <hr />
        &copy; {{ date('Y') }} {{ __('footer.copyright') }} <a href="https://github.com/den15dev/eshop2" class="link">den15</a>
    </div>
</footer>