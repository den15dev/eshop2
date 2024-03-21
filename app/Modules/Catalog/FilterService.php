<?php

namespace App\Modules\Catalog;

use App\Modules\Brands\Models\Brand;
use App\Modules\Catalog\Enums\ProductSorting;
use App\Modules\Categories\Models\Specification;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Products\Models\Sku;
use App\Modules\Products\ValueObjects\Price;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FilterService
{
    private const RATE_QUERY = '(SELECT currencies.exchange_rate FROM currencies where skus.currency_id = currencies.id)';


    public function buildFilteredQuery(int|string $category_id, array $query_arr): Builder
    {
        $db_query = Sku::join('products', 'skus.product_id', 'products.id')
            ->leftJoin('promos', function (JoinClause $join) {
                $current_date = date('Y-m-d H:i:s');
                $join->on('skus.promo_id', '=', 'promos.id')
                    ->whereDate('promos.starts_at', '<=', $current_date)
                    ->whereDate('promos.ends_at', '>=', $current_date);
            })
            ->when(isset($query_arr['specs']), function (Builder $query) {
                $query->join('sku_specification AS ss', 'skus.id', 'ss.sku_id');
            })
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'products.category_id',
                'skus.short_descr',
                'skus.currency_id',
                'skus.price',
                'skus.discount_prc',
                'skus.final_price',
                'skus.rating',
                'skus.vote_num',
                'promos.id as promo_id',
                'promos.name as promo_name',
                'promos.slug as promo_slug',
            )
            ->where('products.category_id', $category_id);

        if (isset($query_arr['brands'])) {
            $db_query = $db_query->whereIn('products.brand_id', $query_arr['brands']);
        }

        if (isset($query_arr['price_min']) && is_numeric($query_arr['price_min'])) {
            $price_min = bcmul(Price::parse($query_arr['price_min']), CurrencyService::$cur_currency->exchange_rate);
            $db_query = $db_query->where(DB::raw('skus.final_price * ' . self::RATE_QUERY), '>=', $price_min);
        }

        if (isset($query_arr['price_max']) && is_numeric($query_arr['price_max'])) {
            $price_max = bcmul(Price::parse($query_arr['price_max']), CurrencyService::$cur_currency->exchange_rate);
            $db_query = $db_query->where(DB::raw('skus.final_price * ' . self::RATE_QUERY), '<=', $price_max);
        }

        if (isset($query_arr['specs'])) {
            $specs = $query_arr['specs'];
            $lang = app()->getLocale();

            $db_query = $db_query->whereIn('skus.id', function (QBuilder $query) use ($specs, $lang) {
                $query->select('ss.sku_id');

                foreach ($specs as $key => $value_list) {
                    if ($key === array_key_first($specs)) {
                        $query->where('ss.specification_id', $key)->whereIn('spec_value->' . $lang, $value_list);
                    } else {
                        $query->orWhere('ss.specification_id', $key)->whereIn('spec_value->' . $lang, $value_list);
                    }
                }
            });
        }

        $db_query = $db_query->active();

        return $db_query;
    }


    public function sortQuery(Builder $query, \stdClass $sorting): Builder
    {
        return match ($sorting->sorting) {
            ProductSorting::New->value => $query->orderBy('skus.created_at', 'desc'),
            ProductSorting::Cheap->value => $query->orderBy(DB::raw('skus.final_price * ' . self::RATE_QUERY)),
            ProductSorting::Expensive->value => $query->orderBy(DB::raw('skus.final_price * ' . self::RATE_QUERY), 'desc'),
            ProductSorting::Popular->value => $query->orderByRaw('skus.rating IS NULL, skus.rating DESC')->orderBy('skus.vote_num', 'desc'),
            ProductSorting::Discounted->value => $query->orderBy('skus.discount_prc', 'desc'),
        };
    }


    private function getSomeBrands(?array $checked): Collection
    {
        $brand_names = [
            'AMD',
            'Intel',
            'Nvidia',
            'Gigabyte'
        ];

        $brands = new Collection();
        $checked = $checked ? array_keys($checked) : [];

        foreach ($brand_names as $ind => $name) {
            $brand = new \stdClass();
            $brand->id = $ind + 1;
            $brand->name = $name;
            $brand->product_num = rand(2, 40);
            $brand->is_checked = in_array($brand->id, $checked);
            $brands->push($brand);
        }

        return $brands;
    }


    private function getSomeCategories(): Collection
    {
        $category_names = [
            'Motherboards',
            'VR Headsets And Covers',
            'Laptop backpacks',
            'Professional And Construction Vacuums',
            'Cables And Adapters',
        ];

        $categories = new Collection();

        foreach ($category_names as $ind => $name) {
            $category = new \stdClass();
            $category->id = $ind + 1;
            $category->name = $name;
            $category->product_num = rand(2, 40);
            $categories->push($category);
        }

        return $categories;
    }


    public function getBrandsByCategory(int $category_id, ?array $checked): Collection
    {
        $brands = Brand::join('products', 'brands.id', 'products.brand_id')
            ->join('skus', 'products.id', 'skus.product_id')
            ->selectRaw('brands.id, brands.name, count(skus.id) as skus_num')
            ->groupBy('brands.id')
            ->where('products.category_id', $category_id)
            ->whereDate('skus.available_from', '<=', now())
            ->where(function (Builder $builder) {
                $builder->whereDate('skus.available_until', '>', now())
                    ->orWhereNull('skus.available_until');
            })
            ->orderBy('brands.name')
            ->get();

        foreach ($brands as $brand) {
            $brand->is_checked = $checked && in_array($brand->id, $checked);
        }

        return $brands;
    }


    public function getBrandsBySearchQuery(string $query, ?array $checked): Collection
    {
        return $this->getSomeBrands($checked);
    }


    public function getPriceRange(Builder $db_query): \stdClass
    {
        $price_range = new \stdClass();
        $price_range->min = '';
        $price_range->max = '';
        $price_range->symbol = CurrencyService::$cur_currency->symbol;
        $price_range->is_precedes = CurrencyService::$cur_currency->symbol_precedes;

        $skus = $db_query->get();

        $prices = [];
        foreach ($skus as $sku) {
            $prices[] = Price::from($sku->final_price, $sku->currency_id)->formatted;
        }

        if ($prices) {
            $price_range->min = min($prices);
            $price_range->max = max($prices);
        }

        return $price_range;
    }


    public function getCategoriesBySearchQuery(string $query): Collection
    {
        return $this->getSomeCategories();
    }


    public function getSpecs(int $category_id, ?array $checked): Collection
    {
        $specs = Specification::join('sku_specification AS ss', 'specifications.id', 'ss.specification_id')
            ->join('skus', 'ss.sku_id', 'skus.id')
            ->selectRaw('ss.spec_value, specifications.name, specifications.units, ss.specification_id, count(skus.id) as skus_num')
            ->groupBy('ss.spec_value', 'specifications.name', 'specifications.units', 'ss.specification_id')
            ->where('specifications.category_id', $category_id)
            ->where('specifications.is_filter', true)
            ->whereDate('skus.available_from', '<=', now())
            ->where(function (Builder $builder) {
                $builder->whereDate('skus.available_until', '>', now())
                    ->orWhereNull('skus.available_until');
            })
            ->get();

        $filter_specs = new Collection([]);

        foreach ($specs as $spec) {
            $spec_id = $spec->specification_id;
            $value = new \stdClass();
            $value->value = $spec->spec_value;
            $value->skus_num = $spec->skus_num;
            $value->is_checked = isset($checked[$spec_id]) && in_array($spec->spec_value, $checked[$spec_id]);

            $filter_spec = $filter_specs->firstWhere('id', $spec->specification_id);

            if ($filter_spec) {
                $filter_spec->values->push($value);

            } else {
                $filter_spec = new \stdClass();
                $filter_spec->id = $spec_id;
                $filter_spec->name = $spec->name;
                $filter_spec->units = $spec->units;
                $filter_spec->has_checked = false;

                $values = new Collection();
                $values->push($value);
                $filter_spec->values = $values;

                $filter_specs->push($filter_spec);
            }

            if ($value->is_checked) $filter_spec->has_checked = true;
        }

        foreach ($filter_specs as $spec) {
            $sorted_values = $spec->values->sortBy('value');
            $spec->values = $sorted_values;
        }

        return $filter_specs;
    }
}