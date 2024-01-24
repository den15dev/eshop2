<?php

namespace App\Modules\Languages\Actions;

use App\Modules\Languages\LanguageService;

class GetImageURLAction
{
    public static function run(string $img_dirname, string $img_filename): string
    {
        $url = null;
        $image_root = config('filesystems.disks.public.root') . '/images';

        $languages = [
            'current' => app()->getLocale(),
            'default' => LanguageService::getDefault(),
            'fallback' => LanguageService::getFallback(),
        ];

        foreach ($languages as $lang) {
            if (!$url) {
                $img_path = '/' . $img_dirname . '/' . $lang . '/' . $img_filename;
                if (file_exists($image_root . $img_path)) {
                    $url = asset('storage/images' . $img_path);
                }
            }
        }

        return $url;
    }
}