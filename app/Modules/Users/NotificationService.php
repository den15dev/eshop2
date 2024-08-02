<?php

namespace App\Modules\Users;

use App\Modules\Common\CommonService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificationService
{
    public function get(): Collection
    {
        $notifications = Auth::user()->notifications;

        foreach ($notifications as $notification) {
            $notification->type_snake = Str::snake(substr(strrchr($notification->type, '\\'), 1));
            $notification->created_at_humans = $notification->created_at->tz(CommonService::$timezone)->diffForHumans();
            $notification->created_at_exact = $notification->created_at->tz(CommonService::$timezone)->isoFormat('D MMMM YYYY, H:mm');
            $data = $notification->data;
            $data['orders_link'] = '<a href="' . route('orders') . '" class="link">' . __('orders.orders') . '</a>';
            $notification->data = $data;
        }

        return $notifications;
    }


    public function markAsRead(string $id): \stdClass
    {
        $user = Auth::user();

        DB::table('notifications')
            ->where('id', $id)
            ->where('notifiable_id', $user->id)
            ->update(['read_at' => now()]);

        $response = new \stdClass();
        $unread_count = $user->unreadNotifications->count();
        $response->unread_count = $unread_count;
        $response->unread_report = $unread_count ? trans_choice('user-notifications.unread_count', $unread_count) : __('user-notifications.no_new');

        return $response;
    }


    public function markAllAsRead(): \stdClass
    {
        Auth::user()->unreadNotifications->markAsRead();
        $response = new \stdClass();
        $response->all_read = true;

        return $response;
    }
}