<div class="bottom-menu_cont large" id="bottomNavMenuCont">
    <div class="container px-4">
        <div class="bottom-menu_close-btn">
            <svg><use href="#closeIcon" /></svg>
        </div>

        <x-languages-dropdown type="mobile" :languages="$languages" :curlang="$languages->first()" />

        <ul class="bottom-menu_list">
            <li>
                <a href="#">{{ __('header.top_menu.delivery') }}</a>
            </li>
            <li>
                <a href="#">{{ __('header.top_menu.shops') }}</a>
            </li>
            <li>
                <a href="#">{{ __('header.top_menu.warranty') }}</a>
            </li>
            <li>
                <a href="#">{{ __('header.top_menu.for_customers') }}</a>
            </li>
            <li>
                <a href="#">{{ __('footer.other.help') }}</a>
            </li>
        </ul>
    </div>
</div>