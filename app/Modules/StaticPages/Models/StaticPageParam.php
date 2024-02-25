<?php

namespace App\Modules\StaticPages\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class StaticPageParam extends Model
{
    use HasTranslations;

    public array $translatable = ['val', 'description'];

    protected $guarded = [];

    private static Collection|Null $params = null;
    
    private static string $cache_var = 'general_params';


    public function staticPage(): BelongsTo
    {
        return $this->belongsTo(StaticPage::class);
    }


    public static function getGeneral()
    {
        if (self::$params === null) {
            self::$params = Cache::rememberForever(self::$cache_var, function () {
                return self::whereNull('static_page_id')->get();
            });
        }

        return self::$params;
    }

    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget(self::$cache_var);
        });

        static::deleted(function (self $model) {
            Cache::forget(self::$cache_var);
        });
    }
}
