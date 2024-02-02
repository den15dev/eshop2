<?php

namespace App\Modules\Orders\Enums;

enum OrderStatus: string
{
    case New = 'new';
    case Accepted = 'accepted';
    case Ready = 'ready';
    case Sent = 'sent';
    case Completed = 'completed';
    case Cancelled = 'cancelled';


    public static function getStatus(self $status_case): string
    {
        return match ($status_case) {
            self::New => __('orders.statuses.' . self::New->value),
            self::Accepted => __('orders.statuses.' . self::Accepted->value),
            self::Ready => __('orders.statuses.' . self::Ready->value),
            self::Sent => __('orders.statuses.' . self::Sent->value),
            self::Completed => __('orders.statuses.' . self::Completed->value),
            self::Cancelled => __('orders.statuses.' . self::Cancelled->value),
        };
    }
}
