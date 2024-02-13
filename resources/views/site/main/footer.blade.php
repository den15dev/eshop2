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
                    <a href="#">{{ __('footer.company.about') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.company.news') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.company.for_partners') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.company.vacancies') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.company.privacy') }}</a>
                </li>
            </ul>
        </div>
        <div class="footer-col-cont">
            <div class="footer_section-title">{{ __('footer.for_buyers.title') }}</div>
            <ul class="footer-list">
                <li>
                    <a href="#">{{ __('footer.for_buyers.make_order') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.for_buyers.payment_methods') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.for_buyers.credits') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.for_buyers.for_entities') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.for_buyers.corp_departments') }}</a>
                </li>
            </ul>
        </div>
        <div class="footer-col-cont">
            <div class="footer_section-title">{{ __('footer.other.title') }}</div>
            <ul class="footer-list">
                <li>
                    <a href="#">{{ __('footer.other.delivery') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.other.return') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.other.gift_cards') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.other.bonus_program') }}</a>
                </li>
                <li>
                    <a href="#">{{ __('footer.other.help') }}</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container footer-copyright-cont">
        <hr />
        &copy; {{ date('Y') }} {{ __('footer.copyright') }} <a href="https://github.com/den15dev/eshop2" class="link">den15</a>
    </div>
</footer>