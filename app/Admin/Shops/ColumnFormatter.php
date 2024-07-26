<?php

namespace App\Admin\Shops;

use App\Modules\Shops\Actions\GetOpeningHoursForHumanAction;
use Illuminate\Database\Eloquent\Model;

class ColumnFormatter
{
    private Model $model;
    private string $property;


    public function __construct(
        public string $format
    ){}


    public function get(Model $model, string $property): string
    {
        $this->model = $model;
        $this->property = $property;
        $method = $this->format;

        return $this->$method();
    }


    private function isActive(): string
    {
        $property = $this->property;

        return $this->model->$property ? __('admin/general.yes') : '<span class="lightgrey-text">' . __('admin/general.no') . '</span>';
    }


    private function openingHours(): string
    {
        $property = $this->property;
        $human_arr = GetOpeningHoursForHumanAction::run($this->model->$property);

        return implode('<br>', $human_arr);
    }
}