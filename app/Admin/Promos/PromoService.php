<?php

namespace App\Admin\Promos;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Images\ImageService;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Sku;
use App\Modules\Promos\Models\Promo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class PromoService
{
    public const TABLE_NAME = 'promos';
    public const COLUMNS_COOKIE = 'cls_promos';
    public const ROW_LINKS = true; // A whole table row will be a link (every <td> content will be wrapped by <a> tag)


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


    public static function getAllPromos(): Collection
    {
        return Promo::select('id', 'name', 'slug', 'discount', 'starts_at', 'ends_at')
            ->get();
    }


    public function getStatusText(Carbon $starts_at, Carbon $ends_at): \stdClass
    {
        $status = new \stdClass();

        if ($starts_at->isFuture()) {
            $status->id = 'scheduled';
            $status->description = __('admin/promos.status.scheduled', ['term' => $starts_at->diffForHumans()]);

        } elseif (Carbon::now()->between($starts_at, $ends_at)) {
            $status->id = 'active';
            $status->description = __('admin/promos.status.active');

        } else {
            $status->id = 'ended';
            $status->description = __('admin/promos.status.ended', ['term' => $ends_at->diffForHumans()]);
        }

        return $status;
    }


    public function updateImageNames(int $promo_id, string $old_slug, string $new_slug): void
    {
        if ($new_slug !== $old_slug) {
            $base_dir = Storage::disk('images')->path(Promo::IMG_DIR . '/' . $promo_id);
            $languages = LanguageService::getAll();

            foreach ($languages as $lang) {
                foreach (Promo::IMG_SIZES as $size => $res) {
                    $old_img_path = $base_dir  . '/' . $lang->id . '/' . $old_slug . '_' . $size . '.jpg';

                    if (file_exists($old_img_path)) {
                        $new_img_path = $base_dir  . '/' . $lang->id . '/' . $new_slug . '_' . $size . '.jpg';
                        rename($old_img_path, $new_img_path);
                    }
                }
            }
        }
    }


    public function saveImages(int $promo_id, array $images, string $slug): void
    {
        $promo_dir = Storage::disk('images')->path(Promo::IMG_DIR . '/' . $promo_id);
        if (!is_dir($promo_dir)) mkdir($promo_dir);

        foreach ($images as $lang => $image) {
            $lang_dir = $promo_dir  . '/' . $lang;
            if (!is_dir($lang_dir)) mkdir($lang_dir);

            foreach (Promo::IMG_SIZES as $size => $res) {
                $source_path = $image->path();
                $out_path = $lang_dir . '/' . $slug . '_' . $size . '.jpg';

                if (file_exists($out_path)) unlink($out_path);

                ImageService::saveToSameAspect($source_path, $out_path, $res);
            }
        }
    }


    public function deleteImages(int $promo_id): void
    {
        $base_dir = Storage::disk('images')->path(Promo::IMG_DIR . '/' . $promo_id);
        $languages = LanguageService::getAll();

        foreach ($languages as $lang) {
            $dir = $base_dir . '/' . $lang->id;
            if (is_dir($dir)) {
                $files = array_diff(scandir($dir), array('..', '.'));
                foreach ($files as $file) {
                    unlink($dir . '/' . $file);
                }
                rmdir($dir);
            }
        }

        rmdir($base_dir);
    }


    public function addSkus(string $ids, int $promo_id): int
    {
        $id_arr = $this->parseIds($ids);
        $added_cnt = 0;

        foreach ($id_arr as $id) {
            $added = Sku::where('id', $id)->update(['promo_id' => $promo_id]);
            $added_cnt += $added;
        }

        return $added_cnt;
    }


    /**
     * Convert a string like '3,12,25-28,31' into array of ids.
     */
    public function parseIds(string $ids): array
    {
        $out_arr = [];
        $arr = explode(',', $ids);
        foreach ($arr as $id_block) {
            $id_block = trim($id_block);
            $range_arr = explode('-', $id_block);
            if (count($range_arr) > 1) {
                $start = intval(trim($range_arr[0]));
                $end = intval(trim($range_arr[1]));
                if ($end > $start) {
                    $num = $start;
                    do {
                        if ($num) $out_arr[] = $num;
                        $num++;
                    } while ($num <= $end);
                }
            } else {
                $num = intval($id_block);
                if ($num) $out_arr[] = $num;
            }
        }

        return $out_arr;
    }


    public function deleteSku(int $sku_id): void
    {
        Sku::where('id', $sku_id)->update(['promo_id' => null]);
    }
}