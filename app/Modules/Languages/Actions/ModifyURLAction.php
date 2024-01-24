<?php

namespace App\Modules\Languages\Actions;

use App\Modules\Languages\LanguageService;

class ModifyURLAction
{
    public static function run(string $orig_url, ?string $lang_id): string
    {
        $url = $lang_id;
        $segments = explode('/', trim($orig_url, '/'));

        if (count($segments)) {
            if (LanguageService::getActive()->contains('id', $segments[0])) {
                array_shift($segments);
            }

            if ($path = implode('/', $segments)) {
                $url .= "/{$path}";
            }
        }

        if ($query = request()->getQueryString()) {
            $url .= "?{$query}";
        }

        return $url;
    }
}