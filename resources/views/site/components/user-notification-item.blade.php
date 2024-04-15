<div class="user-notification" data-id="{{ $notif->id }}" data-unread="{{ $notif->read_at ? 'no' : 'yes' }}" data-collapsed="on">
    <div class="user-notification_head {{ $notif->read_at ? '' : 'unread' }}">
        <div class="user-notification_chevron">
            <svg><use href="#sidebarChevron" /></svg>
        </div>
        <div class="user-notification_title">
            {{ __('notifications.' . $notif->type_snake . '.subject', $notif->data) }}
        </div>
        <div class="user-notification_date" title="{{ $notif->created_at_exact }}">
            {{ $notif->created_at_humans }}
        </div>
    </div>

    <div class="user-notification_message">
        {!! __('notifications.' . $notif->type_snake . '.body', $notif->data) !!}
    </div>
</div>