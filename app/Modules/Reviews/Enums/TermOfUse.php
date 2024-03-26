<?php

namespace App\Modules\Reviews\Enums;

enum TermOfUse: string
{
    case Days = 'days';
    case Weeks = 'weeks';
    case Months = 'months';
    case Years = 'years';

    public function description(): string
    {
        $base_path = 'reviews.term.';

        return match ($this) {
            self::Days => __($base_path . self::Days->value),
            self::Weeks => __($base_path . self::Weeks->value),
            self::Months => __($base_path . self::Months->value),
            self::Years => __($base_path . self::Years->value),
        };
    }
}
