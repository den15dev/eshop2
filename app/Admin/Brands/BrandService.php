<?php

namespace App\Admin\Brands;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Brands\Models\Brand;
use Illuminate\Database\Eloquent\Builder;

class BrandService
{
    public const TABLE_NAME = 'brands';
    public const COLUMNS_COOKIE = 'cls_brands';


    public function buildIndexQuery(array $query, IndexTableService $tableService): Builder
    {
        $db_query = Brand::select(
            'id',
            'name',
            'slug',
            'created_at',
        );

        if (isset($query['search'])) {
            $db_query = $tableService->constrainBySearchStr($db_query, $query['search']);
        }

        return isset($query['sort'])
            ? $tableService->orderQuery($db_query, $query)
            : $db_query->orderByDesc('brands.id');
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->search = $query['search'] ?? null;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }
}