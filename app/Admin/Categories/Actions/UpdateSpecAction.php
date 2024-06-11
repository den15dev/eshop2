<?php

namespace App\Admin\Categories\Actions;

use App\Modules\Categories\Models\Specification;

class UpdateSpecAction
{
    public static function run(int $category_id, int $spec_id, array $fields): \stdClass
    {
        $sort = $fields['sort'];
        $old_sort = $fields['old_sort'];
        if ($sort !== $old_sort) {
            if ($sort > $old_sort) {
                Specification::where('category_id', $category_id)
                    ->where('sort', '>', $old_sort)
                    ->where('sort', '<=', $sort)
                    ->decrement('sort');

            } elseif ($sort < $old_sort) {
                Specification::where('category_id', $category_id)
                    ->where('sort', '>=', $sort)
                    ->where('sort', '<', $old_sort)
                    ->increment('sort');
            }

            Specification::where('id', $spec_id)->update(['sort' => $sort]);
        }

        $name = array_filter($fields['name'], fn ($lang) => !empty($lang));
        $units = isset($fields['units'])
            ? array_filter($fields['units'], fn ($lang) => !empty($lang))
            : null;
        $is_filter = isset($fields['is_filter']) && $fields['is_filter'] === 'on';
        $is_main = isset($fields['is_main']) && $fields['is_main'] === 'on';

        Specification::where('id', $spec_id)->update([
            'name' => $name,
            'units' => $units,
            'is_filter' => $is_filter,
            'is_main' => $is_main,
        ]);

        $response = new \stdClass();
        $response->message = __('admin/specifications.messages.spec_updated');

        return $response;
    }
}