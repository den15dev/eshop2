<?php

namespace App\Modules\Promos;

use App\Modules\Products\Models\Sku;
use App\Modules\Promos\Models\Promo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PromoService
{
    /**
     * All active promos will be stored here.
     */
    private static ?Collection $active_promos = null;


    /**
     * Get all active promos and store them in static property.
     */
    public static function getActive(): Collection
    {
        if (self::$active_promos === null) {
            self::$active_promos = Cache::rememberForever('promos', function () {
                $current_date = date('Y-m-d H:i:s');

                return Promo::select('id', 'name', 'slug', 'discount', 'starts_at', 'ends_at')
                    ->whereDate('starts_at', '<=', $current_date)
                    ->whereDate('ends_at', '>=', $current_date)
                    ->get();
            });
        }

        return self::$active_promos;
    }


    public function getPromo(int $id, string $slug): ?Promo
    {
        return Promo::where('id', $id)
            ->where('slug', $slug)
            ->first();
    }


    public function getPromoSkus(int $promo_id)
    {
        return Sku::getCards()
            ->where('promo_id', $promo_id)
            ->get();
    }


    public static function isActive(string $id): bool
    {
        return self::getActive()->contains($id);
    }
}