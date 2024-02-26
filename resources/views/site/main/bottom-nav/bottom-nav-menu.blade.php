<div class="bottom-menu_cont large" id="bottomNavMenuCont">
    <div class="container px-4">
        <div class="bottom-menu_close-btn">
            <svg><use href="#closeIcon" /></svg>
        </div>

        <div class="localization-cont mb-25">
            <x-languages-dropdown type="mobile" :languages="$languages" :curlang="$languages->first()" />
            <x-currencies-dropdown type="mobile" :currencies="$currencies" :curcurr="$currencies->first()" />
        </div>

        <ul class="bottom-menu_list">
            <li>
                <a href="{{ route('delivery') }}">{{ __('delivery.delivery') }}</a>
            </li>
            <li>
                <a href="{{ route('shops') }}">{{ __('shops.shops') }}</a>
            </li>
            <li>
                <a href="{{ route('warranty') }}">{{ __('warranty.warranty') }}</a>
            </li>
            <li>
                <a href="#">{{ __('header.top_menu.for_customers') }}</a>
            </li>
            <li>
                <a href="#">{{ __('footer.other.help') }}</a>
            </li>
            <li class="tel">
                <a href="tel:{{ $phone_tel }}">
                    <svg class="tel-icon">
                        <use href="#telIcon"/>
                    </svg>
                    {{ $phone }}
                </a>
            </li>
        </ul>
    </div>
</div>