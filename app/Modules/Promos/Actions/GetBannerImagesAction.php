<?php

namespace App\Modules\Promos\Actions;

use App\Modules\Languages\LanguageService;

class GetBannerImagesAction
{
    public static function run(int $promo_id, string $promo_slug): \stdClass
    {
        $sizes = [1296, 1140, 992, 788, 400];
        $images = new \stdClass();

        foreach ($sizes as $size) {
            $size_prop = 'size_' . $size;
            $images->$size_prop = LanguageService::getImageURL('promos/' . $promo_id, $promo_slug . '_' . $size . '.jpg');
        }

        return $images;
    }
}