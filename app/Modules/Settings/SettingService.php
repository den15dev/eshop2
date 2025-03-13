<?php

namespace App\Modules\Settings;

use App\Modules\Settings\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    private static ?Collection $settings = null;


    public static function getAll(): Collection
    {
        if (self::$settings === null) {
            self::$settings = Cache::rememberForever('settings', function () {
                return Setting::orderBy('created_at')->get();
            });
        }

        return self::$settings;
    }


    public static function get(string $id): mixed
    {
        return self::getAll()->firstWhere('id', $id)->val;
    }
}
