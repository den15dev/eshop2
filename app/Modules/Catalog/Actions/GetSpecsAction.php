<?php

namespace App\Modules\Catalog\Actions;

use App\Modules\Categories\Models\Specification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class GetSpecsAction
{
    public static function run(int $category_id, ?array $checked): Collection
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