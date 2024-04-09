<?php

namespace App\Modules\Orders\Enums;

enum PaymentStatus: string
{
    case Paid = 'paid';
    case NotPaid = 'not_paid';
    case Pending = 'pending';


    public function description(): string
    {
        $base_path = 'orders.payment_statuses.';

        return match ($this) {
            self::Paid => __($base_path . self::Paid->value),
            self::NotPaid => __($base_path . self::NotPaid->value),
            self::Pending => __($base_path . self::Pending->value),
        };
    }
}
