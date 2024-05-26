<?php

namespace App\Admin\Promos;

use App\Modules\Promos\Models\Promo;
use Illuminate\Support\Collection;

class PromoService
{
    public static function getAllPromos(): Collection
    {
        return Promo::select('id', 'name', 'slug', 'discount', 'starts_at', 'ends_at')
            ->get();
    }
}