@extends('site.layout')

@section('page_title', __('user-notifications.notifications') . ' - ' . __('general.app_name'))

@section('main_content')
    <div class="container">
        <h3 class="mb-3">{{ __('user-notifications.notifications') }}</h3>

        @if($notifications->count())
            <div class="user-notifications_wrap">
                <div class="user-notifications_top-cont mb-4">
                    @if($unread_count)
                        <div class="user-notifications_count">{{ trans_choice('user-notifications.unread_count', $unread_count) }}</div>
                        <div class="link text-end" id="markAllAsReadBtn">{{ __('user-notifications.mark_read') }}</div>
                    @else
                        <div class="user-notifications_count no-new">{{ __('user-notifications.no_new') }}</div>
                    @endif
                </div>

                <div class="user-notifications_cont">
                    @foreach($notifications as $notification)
                        <x-user-notification-item :notif="$notification" />
                    @endforeach
                </div>
            </div>
        @else
            <div class="items-not-found">
                {{ __('user-notifications.no_notifications') }}
            </div>
        @endif
    </div>
@endsection