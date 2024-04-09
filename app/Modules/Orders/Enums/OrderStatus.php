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


    public function description(): string
    {
        $base_path = 'orders.statuses.';

        return match ($this) {
            self::New => __($base_path . self::New->value),
            self::Accepted => __($base_path . self::Accepted->value),
            self::Ready => __($base_path . self::Ready->value),
            self::Sent => __($base_path . self::Sent->value),
            self::Completed => __($base_path . self::Completed->value),
            self::Cancelled => __($base_path . self::Cancelled->value),
        };
    }
}
