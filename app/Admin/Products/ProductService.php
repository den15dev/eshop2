<?php

namespace App\Admin\Products;

use App\Admin\Categories\CategoryService as AdmCategoryService;
use App\Admin\IndexTable\IndexTableService;
use App\Modules\Categories\CategoryService;
use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public const TABLE_NAME = 'products';
    public const COLUMNS_COOKIE = 'cls_products';
    public array $columns;


    public function __construct(
        private readonly AdmCategoryService $categoryService,
        private readonly IndexTableService $tableService,
    ){}


    public function getColumns(?array $query = null): array
    {
        if (!isset($this->columns)) {
            $columns = include_once __DIR__ . '/columns.php';

            if (isset($query['sort'])) {
                foreach ($columns as &$column) {
                    if ($column['id'] === $query['sort']) {
                        $column['sort_order'] = $query['order'];
                        break;
                    }
                }
            }

            $this->columns = $columns;
        }

        return $this->columns;
    }


    public function getSkusQuery(array $query): Builder
    {
        // All the column ids in the "columns" array must present
        // in the "select" statement

        $columns = $this->getColumns();

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
                'skus.sku',
                'products.category_id',
                'categories.name as category_name',
                'brands.name as brand_name',
                'skus.currency_id',
                'skus.price',
                'skus.discount_prc',
                'skus.final_price',
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
            $db_query = $this->tableService->constrainBySearchStr($db_query, $query['search'], $this->getColumns());
        }

        if (isset($query['chb'])) {
            $checkboxes = [];
            foreach ($query['chb'] as $key => $val) {
                $checkboxes[$key] = $val === 'true';
            }

            $db_query = $this->constrainByCheckboxes($db_query, $checkboxes);
        }

        return isset($query['sort'])
            ? $this->orderQuery($db_query, $query)
            : $db_query->orderByDesc('skus.id');
    }


    private function constrainByCheckboxes(Builder $db_query, array $checkboxes): Builder
    {
        if ($checkboxes['active'] && !$checkboxes['out_of_stock'] && !$checkboxes['scheduled']) {
            $db_query->active();

        } elseif (!$checkboxes['active'] && $checkboxes['out_of_stock'] && !$checkboxes['scheduled']) {
            $db_query = $db_query->whereDate('skus.available_until', '<=', now());

        } elseif (!$checkboxes['active'] && !$checkboxes['out_of_stock'] && $checkboxes['scheduled']) {
            $db_query = $db_query->whereDate('skus.available_from', '>', now());

        } elseif ($checkboxes['active'] && $checkboxes['out_of_stock'] && !$checkboxes['scheduled']) {
            $db_query = $db_query->whereDate('skus.available_from', '<=', now());

        } elseif ($checkboxes['active'] && !$checkboxes['out_of_stock'] && $checkboxes['scheduled']) {
            $db_query = $db_query->whereDate('skus.available_until', '>', now())
                ->orWhereNull('skus.available_until');

        } elseif (!$checkboxes['active'] && $checkboxes['out_of_stock'] && $checkboxes['scheduled']) {
            $db_query = $db_query->whereDate('skus.available_from', '>', now())
                ->orWhereDate('skus.available_until', '<=', now());

        } elseif (!$checkboxes['active'] && !$checkboxes['out_of_stock'] && !$checkboxes['scheduled']) {
            $db_query = $db_query->whereNull('skus.available_from');
        }

        return $db_query;
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->search = $query['search'] ?? null;
        $state->category_id = isset($query['category']) ? intval($query['category']) : null;
        $state->active = isset($query['chb']['active']) ? $query['chb']['active'] === 'true' : true;
        $state->out_of_stock = isset($query['chb']['out_of_stock']) ? $query['chb']['out_of_stock'] === 'true' : true;
        $state->scheduled = isset($query['chb']['scheduled']) ? $query['chb']['scheduled'] === 'true' : true;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }


    private function orderQuery(Builder $db_query, $query): Builder
    {
        $order_by = 'skus.id';
        foreach ($this->getColumns() as $column) {
            if ($column['id'] === $query['sort']) {
                $order_by = $column['order_by'];
                break;
            }
        }

        return $db_query->orderBy($order_by, $query['order']);
    }
}