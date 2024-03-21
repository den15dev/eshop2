<?php

namespace App\Http\Middleware;

use App\Modules\Catalog\CatalogService;
use App\Modules\Catalog\ComparisonService;
use App\Modules\Favorites\FavoriteService;
use App\Modules\Products\RecentlyViewedService;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
        CatalogService::PREF_COOKIE,
        ComparisonService::COOKIE,
        FavoriteService::COOKIE,
        RecentlyViewedService::COOKIE,
    ];
}
