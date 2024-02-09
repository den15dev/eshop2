<?php

namespace App\Http\Middleware;

use App\Modules\Catalog\CatalogService;
use App\Modules\Products\ComparisonService;
use App\Modules\Products\FavoriteService;
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
    ];
}
