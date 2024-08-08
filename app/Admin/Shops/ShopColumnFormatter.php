<?php

namespace App\Admin\Shops;

use App\Admin\IndexTable\ColumnFormatter;
use App\Modules\Shops\Actions\GetOpeningHoursForHumanAction;

final class ShopColumnFormatter extends ColumnFormatter
{
    protected function isActive(): string
    {
        $property = $this->property;

        return $this->model->$property ? __('admin/general.yes') : '<span class="lightgrey-text">' . __('admin/general.no') . '</span>';
    }


    protected function openingHours(): string
    {
        $property = $this->property;
        $human_arr = GetOpeningHoursForHumanAction::run($this->model->$property);

        return implode('<br>', $human_arr);
    }
}