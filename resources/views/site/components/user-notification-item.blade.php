<div class="user-notification" data-id="{{ $notif->id }}" data-unread="{{ $notif->is_unread ? 'yes' : 'no' }}" data-collapsed="on">
    <div class="user-notification_head {{ $notif->is_unread ? 'unread' : '' }}">
        <div class="user-notification_chevron">
            <svg><use href="#sidebarChevron" /></svg>
        </div>
        <div class="user-notification_title">
            {{ $notif->title }}
        </div>
        <div class="user-notification_date" title="{{ $notif->created_at_exact }}">
            {{ $notif->created_at_humans }}
        </div>
    </div>

    <div class="user-notification_message">
        {{ $notif->message }}
    </div>
</div>