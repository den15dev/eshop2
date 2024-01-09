<?php

namespace App\Modules\Languages;

use App\Modules\Languages\Actions\ModifyURLAction;
use App\Modules\Languages\Models\Language;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class LanguageService
{
    /**
     * All languages will be stored here.
     * @var Collection|null
     */
    private static ?Collection $languages = null;


    /**
     * Get all languages and store them in static property.
     *
     * @return Collection
     */
    public static function getAll(): Collection
    {
        if (self::$languages === null) {
            $languages = Cache::rememberForever('languages', function () {
                return Language::all();
            });

            self::$languages = $languages->count() ? $languages : self::createDefault();
        }

        return self::$languages;
    }


    /**
     * Create default language collection
     * in case a database is empty.
     *
     * @return Collection
     */
    private static function createDefault(): Collection
    {
        return new Collection([
            (new Language())->fill([
                'id' => 'en',
                'name' => 'English',
                'active' => true,
                'default' => true,
                'fallback' => true,
            ])
        ]);
    }


    public static function getActive(): Collection
    {
        return self::getAll()->where('active', true);
    }

    private static function getDefault(): Language
    {
        return self::getActive()
            ->where('default', true)
            ->first();
    }

    private static function getFallback(): Language
    {
        return self::getActive()
            ->where('fallback', true)
            ->first();
    }


    /**
     * For convenience, move preferred language
     * to the beginning of the collection.
     *
     * @param string $pref_lang_id
     * @return void
     */
    private static function sortLanguages(string $pref_lang_id): void
    {
        if (self::$languages !== null) {
            self::$languages = self::$languages->sortBy(fn($item) => $item->id !== $pref_lang_id);
        }
    }


    public static function setLocale($lang_id): void
    {
        self::sortLanguages($lang_id);
        app()->setLocale($lang_id);
        Carbon::setLocale($lang_id);
    }


    public static function setDefaultLanguage(): void
    {
        $default_language = self::getDefault();
        LanguageService::setLocale($default_language->id);
    }


    public static function setFallbackLanguage(): void
    {
        $fb_language = self::getFallback();
        app()->setFallbackLocale($fb_language->id);
        Carbon::setFallbackLocale($fb_language->id);
    }


    /**
     * Check if a URL has a language prefix and such
     * a language exists in the language list.
     *
     * @param string|null $urlSegment1
     * @return string|null
     */
    public static function getRoutePrefix(?string $urlSegment1): string|null
    {
        return LanguageService::getActive()->doesntContain('id', $urlSegment1)
            ? null
            : $urlSegment1;
    }


    /**
     * Substitute or add specified language id in the beginning
     * of the URL.
     *
     * @param string $orig_url - without 'http://example.com'
     * @param string|null $lang_id
     * @return string
     */
    public static function modifyURL(string $orig_url, string|null $lang_id): string
    {
        return ModifyURLAction::run($orig_url, $lang_id);
    }
}