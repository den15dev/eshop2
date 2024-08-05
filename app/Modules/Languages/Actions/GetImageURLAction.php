<?php

namespace App\Modules\Languages\Actions;

use Illuminate\Support\Facades\Storage;

class GetImageURLAction
{
    public static function run(string $img_dirname, string $img_filename, ?string $lang = null): ?string
    {
        if ($lang) {
            $img_path = '/' . $img_dirname . '/' . $lang . '/' . $img_filename;
            return asset(config('filesystems.disks.images.relative_url') . $img_path);
        }

        $url = null;

        $languages = [
            'current' => app()->getLocale(),
            'fallback' => app()->getFallbackLocale(),
        ];

        foreach ($languages as $lang) {
            if (!$url) {
                $img_path = '/' . $img_dirname . '/' . $lang . '/' . $img_filename;
                if (file_exists(Storage::disk('images')->path($img_path))) {
                    $url = asset(config('filesystems.disks.images.relative_url') . $img_path);
                }
            }
        }

        return $url ?? asset('img/default/no-image_promo.jpg');
    }
}