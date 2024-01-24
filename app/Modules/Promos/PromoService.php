<?php

namespace App\Modules\Promos;

use App\Modules\Languages\LanguageService;
use App\Modules\Promos\Actions\GetBannerImagesAction;
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

                return Promo::select('id', 'name', 'slug', 'starts_at', 'ends_at')
                    ->whereDate('starts_at', '<=', $current_date)
                    ->whereDate('ends_at', '>=', $current_date)
                    ->get();
            });
        }

        return self::$active_promos;
    }


    public function getBannerImages(int $promo_id, string $promo_slug): \stdClass
    {
        return GetBannerImagesAction::run($promo_id, $promo_slug);
    }


    /**
     * Get active promos with banners for current language.
     */
    public function getBanners(): Collection
    {
        $promos = PromoService::getActive();

        foreach ($promos as $promo) {
            $promo->images = $this->getBannerImages($promo->id, $promo->slug);
        }

        return $promos;
    }


    public static function isActive(string $id): bool
    {
        return self::getActive()->contains($id);
    }
}