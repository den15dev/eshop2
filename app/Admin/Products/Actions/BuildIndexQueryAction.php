<?php

namespace App\Admin\Products\Actions;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Categories\CategoryService as AdmCategoryService;
use App\Modules\Categories\CategoryService;
use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class BuildIndexQueryAction
{
    public function __construct(
        private readonly AdmCategoryService $categoryService,
    ){}


    public function run(
        array $query,
        IndexTableService $tableService,
    ): EBuilder {
        $sku_count = Sku::select(
                'product_id',
                DB::raw('count(*) as sku_count'),
            )
            ->groupBy('product_id');

        $db_query = Sku::join('products', 'skus.product_id', 'products.id')
            ->joinSub($sku_count, 'sku_count', function (JoinClause $join) {
                $join->on('skus.product_id', 'sku_count.product_id');
            })
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('brands', 'products.brand_id', 'brands.id')
            ->leftJoin('promos', 'skus.promo_id', 'promos.id')
            ->select(
                'skus.id',
                'skus.product_id',
                'products.name as product_name',
                'sku_count',
                'skus.name',
                'skus.slug',
                'skus.code',
                'skus.sku',
                'products.category_id',
                'categories.name as category_name',
                'brands.name as brand_name',
                'skus.currency_id',
                'skus.price',
                DB::raw(Sku::DISCOUNT_FILTERED . ' as discount'),
                'skus.rating',
                'skus.vote_num',
                'skus.available_from',
                'skus.available_until',
                'skus.promo_id',
                'promos.name as promo_name',
                'skus.created_at',
            );

        if (isset($query['category'])) {
            $children_ids = $this->categoryService->getAllChildrenIds($query['category'], CategoryService::getAll());

            $db_query = $db_query->whereIn('products.category_id', $children_ids);
        }

        if (isset($query['search'])) {
            $db_query = $tableService->constrainBySearchStr($db_query, $query['search']);
        }

        if (isset($query['chb'])) {
            $checkboxes = [];
            foreach ($query['chb'] as $key => $val) {
                $checkboxes[$key] = $val === 'true';
            }

            $db_query = $this->constrainByCheckboxes($db_query, $checkboxes);
        }

        return isset($query['sort'])
            ? $tableService->orderQuery($db_query, $query)
            : $db_query->orderByDesc('skus.id');
    }


    private function constrainByCheckboxes(EBuilder $db_query, array $checkboxes): EBuilder
    {
        if (count($checkboxes) === 1) {
            if (isset($checkboxes['active'])) {
                $db_query->active();

            } elseif (isset($checkboxes['out_of_stock'])) {
                $db_query = $db_query->whereDate('skus.available_until', '<=', now());

            } elseif (isset($checkboxes['scheduled'])) {
                $db_query = $db_query->whereDate('skus.available_from', '>', now());
            }

        } elseif (count($checkboxes) === 2) {
            if (isset($checkboxes['active']) && isset($checkboxes['out_of_stock'])) {
                $db_query = $db_query->whereDate('skus.available_from', '<=', now());

            } elseif (isset($checkboxes['active']) && isset($checkboxes['scheduled'])) {
                $db_query = $db_query->where(function (EBuilder $query) {
                    $query->whereDate('skus.available_until', '>', now())
                        ->orWhereNull('skus.available_until');
                });

            } elseif (isset($checkboxes['out_of_stock']) && isset($checkboxes['scheduled'])) {
                $db_query = $db_query->where(function (EBuilder $query) {
                    $query->whereDate('skus.available_from', '>', now())
                        ->orWhereDate('skus.available_until', '<=', now());
                });
            }
        }

        return $db_query;
    }
}
