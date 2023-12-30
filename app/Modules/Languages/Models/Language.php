<?php

namespace App\Modules\Languages\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class Language extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'active' => 'boolean',
        'default' => 'boolean',
        'fallback' => 'boolean',
    ];

    private static Collection|null $languages = null;

    private static array $languages_default = [
        'id' => 'en',
        'name' => 'English',
        'active' => true,
        'default' => true,
        'fallback' => true,
    ];


    /**
     * Gets all languages and stores in static property.
     *
     * @return Collection
     */
    public static function getAll(): Collection
    {
        if (self::$languages === null) {

            $languages_default = new Collection([(new static)->fill(self::$languages_default)]);

            $db_languages = Cache::rememberForever('languages', function () {
                return self::all();
            });

            self::$languages = $db_languages->count() ? $db_languages : $languages_default;
        }

        return self::$languages;
    }


    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('languages');
        });

        static::deleted(function (self $model) {
            Cache::forget('languages');
        });
    }


    public static function getDefault()
    {
        return self::getAll()
            ->where('active', true)
            ->where('default', true)
            ->first();
    }

    public static function getFallback()
    {
        return self::getAll()
            ->where('active', true)
            ->where('fallback', true)
            ->first();
    }

    public static function getActive(): Collection
    {
        return self::getAll()->where('active', true);
    }

    public static function sortLanguages(string $pref_lang_id): void
    {
        if (self::$languages !== null) {
            self::$languages = self::$languages->sortBy(fn($item) => $item->id !== $pref_lang_id);
        }
    }


    public static function setLocale($lang_id): void
    {
        Language::sortLanguages($lang_id);
        app()->setLocale($lang_id);
        Carbon::setLocale($lang_id);
    }


    /**
     * Checks if a URL has a language prefix and such
     * a language exists in the language list.
     *
     * @return string|null
     */
    public static function getRoutePrefix(): string|null
    {
        $prefix = request()->segment(1);
        $activeLanguages = static::getActive();

        if ($activeLanguages->doesntContain('id', $prefix)) {
            $prefix = null;
        }

        return $prefix;
    }


    /**
     * Substitute or add specified language id in the beginning
     * of the URL.
     *
     * @param string $orig_url - without 'http://example.com'
     * @param string|null $lang_id
     * @return string
     */
    public static function buildURL(string $orig_url, string|null $lang_id): string
    {
        $url = $lang_id;
        $segments = explode('/', trim($orig_url, '/'));

        if (count($segments)) {
            if (static::getActive()->contains('id', $segments[0])) {
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
