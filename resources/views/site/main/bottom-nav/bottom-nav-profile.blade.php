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
                <a href="{{ route('admin.dashboard') }}">
                    <svg><use href="#adminPanelIcon"/></svg>
                    {{ __('header.user_menu.profile_menu.admin_panel') }}
                </a>
            </li>
            @endif
            <li>
                <a href="{{ route('profile') }}">
                    <svg><use href="#profileSettingsIcon"/></svg>
                    {{ __('header.user_menu.profile_menu.profile') }}
                </a>
            </li>
            <li>
                <a href="{{ route('notifications') }}">
                    <svg><use href="#profileNotificationsIcon"/></svg>
                    {{ __('header.user_menu.profile_menu.notifications') }}
                    <div class="badge-round_inline-big-red {{ $unread_notifications_num ? 'active' : '' }}" id="unreadNotificationsBadgeMobile">{{ $unread_notifications_num }}</div>
                </a>
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div id="bnavLogoutBtn">
                        <svg style="margin-left: -2px"><use href="#profileLogoutIcon"/></svg>
                        {{ __('header.user_menu.profile_menu.logout') }}
                    </div>
                </form>
            </li>
        </ul>
    </div>
</div>