<?php

namespace App\Modules\Users;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class NotificationService
{
    private function tempCreate(int $id, bool $is_unread): \stdClass
    {
        $notification = new \stdClass();

        $notification->id = $id;
        $notification->user_id = 3;
        $notification->title = 'Заказ №6 отправлен';
        $notification->message = 'Заказ №6 передан в службу доставки. Пожалуйста, ожидайте звонка курьера.';
        $notification->is_unread = $is_unread;

        $creation_date = fake()->dateTimeBetween('-1 week');
        $notification->created_at = $creation_date;
        $notification->created_at_humans = Carbon::parse($creation_date)->diffForHumans();
        $notification->created_at_exact = Carbon::parse($creation_date)->isoFormat('D MMMM YYYY, H:mm');

        return $notification;
    }


    public function get(): Collection
    {
        $notifications = new Collection();

        for ($i = 0; $i < 5; $i++) {
            $id = $i + 1;
            $is_unread = !$i;
            $notification = $this->tempCreate($id, $is_unread);
            $notifications->push($notification);
        }

        return $notifications;
    }
}