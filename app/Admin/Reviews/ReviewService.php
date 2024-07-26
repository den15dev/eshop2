<?php

namespace App\Admin\Reviews;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Products\Models\Sku;
use App\Modules\Reviews\Models\Review;
use Illuminate\Database\Eloquent\Builder as EBuilder;

class ReviewService
{
    public const TABLE_NAME = 'reviews';
    public const COLUMNS_COOKIE = 'cls_reviews';
    public const ROW_LINKS = true; // A whole table row will be a link (every <td> content will be wrapped by <a> tag)


    public function buildIndexQuery(array $query, IndexTableService $tableService): EBuilder
    {
        $db_query = Review::select(
            'reviews.*',
        );

        if (isset($query['search'])) {
            $db_query = $tableService->constrainBySearchStr($db_query, $query['search']);
        }

        return isset($query['sort'])
            ? $tableService->orderQuery($db_query, $query)
            : $db_query->orderByDesc(self::TABLE_NAME . '.id');
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->search = $query['search'] ?? null;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }


    public function getReview(int $id): Review
    {
        return Review::withCount([
            'reactions as likes' => function ($query) { $query->where('up_down', true); },
            'reactions as dislikes' => function ($query) { $query->where('up_down', false); },
        ])->find($id);
    }


    public function getSku(int $sku_id)
    {
        return Sku::join('products', 'skus.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'products.category_id',
                'categories.slug as category_slug',
            )
            ->firstWhere('skus.id', $sku_id);
    }
}