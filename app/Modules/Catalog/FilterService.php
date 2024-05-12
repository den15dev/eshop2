<?php

namespace App\Modules\Catalog;

use App\Modules\Catalog\Actions\BuildCatalogDBQueryAction;
use App\Modules\Catalog\Actions\BuildSearchDBQueryAction;
use App\Modules\Catalog\Actions\GetBrandsAction;
use App\Modules\Catalog\Actions\GetCategoriesAction;
use App\Modules\Catalog\Actions\GetPriceRangeAction;
use App\Modules\Catalog\Actions\GetSpecsAction;
use App\Modules\Catalog\Enums\ProductSorting;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FilterService
{
    public function buildCatalogDBQuery(int $category_id, array $query_arr): Builder
    {
        return BuildCatalogDBQueryAction::run($category_id, $query_arr);
    }


    public function buildSearchDBQuery(string $search_query, array $query_arr): Builder
    {
        return BuildSearchDBQueryAction::run($search_query, $query_arr);
    }


    public function sortQuery(Builder $query, \stdClass $sorting): Builder
    {
        return match ($sorting->sorting) {
            ProductSorting::New->value => $query->orderBy('skus.created_at', 'desc'),
            ProductSorting::Cheap->value => $query->orderBy(DB::raw(Sku::FINAL_PRICE . ' * ' . CurrencyService::RATE_SUBQUERY)),
            ProductSorting::Expensive->value => $query->orderBy(DB::raw(Sku::FINAL_PRICE . ' * ' . CurrencyService::RATE_SUBQUERY), 'desc'),
            ProductSorting::Popular->value => $query->orderByRaw('skus.rating IS NULL, skus.rating DESC')->orderBy('skus.vote_num', 'desc'),
            ProductSorting::Discounted->value => $query->orderBy(DB::raw(Sku::DISCOUNT), 'desc'),
        };
    }


    public function getBrandsByCategory(int $category_id, ?array $checked): Collection
    {
        return GetBrandsAction::run('products.category_id', '=', $category_id, $checked);
    }


    public function getBrandsBySearchQuery(string $search_query, ?array $checked): Collection
    {
        return GetBrandsAction::run('skus.name->' . app()->getLocale(), 'ilike', '%' . $search_query . '%', $checked);
    }


    public function getPriceRange(Builder $db_query): \stdClass
    {
        return GetPriceRangeAction::run($db_query);
    }


    public function getCategories(string $search_query, ?array $checked): Collection
    {
        return GetCategoriesAction::run($search_query, $checked);
    }


    public function getSpecs(int $category_id, ?array $checked): Collection
    {
        return GetSpecsAction::run($category_id, $checked);
    }
}