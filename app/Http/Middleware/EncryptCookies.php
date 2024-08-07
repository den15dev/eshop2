<?php

namespace App\Http\Middleware;

use App\Admin\Brands\BrandService;
use App\Admin\IndexTable\IndexTableService;
use App\Admin\Orders\OrderService;
use App\Admin\Products\ProductService;
use App\Admin\Promos\PromoService;
use App\Admin\Reviews\ReviewService;
use App\Admin\Shops\ShopService;
use App\Admin\Users\UserService;
use App\Modules\Cart\CartService;
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
        'tz',
        CatalogService::PREF_COOKIE,
        CartService::COOKIE,
        ComparisonService::COOKIE,
        FavoriteService::COOKIE,
        RecentlyViewedService::COOKIE,

        // Admin panel
        IndexTableService::PER_PAGE_COOKIE,
        ProductService::COLUMNS_COOKIE,
        BrandService::COLUMNS_COOKIE,
        PromoService::COLUMNS_COOKIE,
        OrderService::COLUMNS_COOKIE,
        UserService::COLUMNS_COOKIE,
        ReviewService::COLUMNS_COOKIE,
        ShopService::COLUMNS_COOKIE,
    ];
}
