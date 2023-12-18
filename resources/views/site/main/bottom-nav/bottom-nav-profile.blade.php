<div class="bottom-menu_cont large pt-35" id="bottomNavProfileCont">
    <div class="container px-4">
        <div class="bottom-menu_close-btn">
            <svg><use href="#closeIcon" /></svg>
        </div>

        <ul class="bottom-menu_list">
            <li>
                <div class="user-name">
                    {{ Auth::user()?->name }}
                </div>
            </li>
            @if(Auth::user()?->isAdmin())
            <li>
                <span class="icon-key lightgrey-text me-1"></span>
                <a href="#">{{ __('header.user_menu.profile_menu.admin_panel') }}</a>
            </li>
            @endif
            <li>
                <span class="icon-gear lightgrey-text me-1"></span>
                <a href="#">{{ __('header.user_menu.profile_menu.settings') }}</a>
            </li>
            <li>
                <span class="icon-bell lightgrey-text me-1"></span>
                <a href="#">{{ __('header.user_menu.profile_menu.notifications') }}</a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div id="bnavLogoutBtn">
                        <span class="icon-box-arrow-right lightgrey-text me-1"></span>
                        {{ __('header.user_menu.profile_menu.logout') }}
                    </div>
                </form>
            </li>
        </ul>
    </div>
</div>