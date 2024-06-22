<?php

namespace App\Admin\Promos;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Promos\Models\Promo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PromoService
{
    public const TABLE_NAME = 'promos';
    public const COLUMNS_COOKIE = 'cls_promos';


    public function buildIndexQuery(array $query, IndexTableService $tableService): Builder
    {
        $db_query = Promo::select(
            'id',
            'name',
            'slug',
            'discount',
            'starts_at',
            'ends_at',
            'created_at',
        );

        if (isset($query['search'])) {
            $db_query = $tableService->constrainBySearchStr($db_query, $query['search']);
        }

        return isset($query['sort'])
            ? $tableService->orderQuery($db_query, $query)
            : $db_query->orderByDesc('promos.id');
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->search = $query['search'] ?? null;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }


    public static function getAllPromos(): Collection
    {
        return Promo::select('id', 'name', 'slug', 'discount', 'starts_at', 'ends_at')
            ->get();
    }


    public function getStatusText(Promo $promo): \stdClass
    {
        $status = new \stdClass();

        if ($promo->starts_at->isFuture()) {
            $status->id = 'scheduled';
            $status->description = __('admin/promos.status.scheduled', ['term' => $promo->starts_at->diffForHumans()]);

        } elseif (Carbon::now()->between($promo->starts_at, $promo->ends_at)) {
            $status->id = 'active';
            $status->description = __('admin/promos.status.active');

        } else {
            $status->id = 'ended';
            $status->description = __('admin/promos.status.ended', ['term' => $promo->ends_at->diffForHumans()]);
        }

        return $status;
    }
}