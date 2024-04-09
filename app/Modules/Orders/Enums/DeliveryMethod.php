<?php

namespace App\Modules\Orders\Enums;

enum DeliveryMethod: string
{
    case Delivery = 'delivery';
    case SelfDelivery = 'self-delivery';


    public function description(): string
    {
        $base_path = 'orders.delivery_methods.';

        return match ($this) {
            self::Delivery => __($base_path . self::Delivery->value),
            self::SelfDelivery => __($base_path . self::SelfDelivery->value),
        };
    }
}
