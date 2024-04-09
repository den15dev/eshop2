<?php

namespace App\Modules\Orders\Enums;

enum PaymentMethod: string
{
    case Online = 'online';
    case CourierCard = 'courier_card';
    case CourierCash = 'courier_cash';
    case Shop = 'shop';


    public function description()
    {
        $base_path = 'orders.payment_methods.';

        return match ($this) {
            self::Online => __($base_path . self::Online->value),
            self::CourierCard => __($base_path . self::CourierCard->value),
            self::CourierCash => __($base_path . self::CourierCash->value),
            self::Shop => __($base_path . self::Shop->value),
        };
    }
}
