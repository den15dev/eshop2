<?php

namespace App\Admin\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;

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


    private function role()
    {
        $property = $this->property;
        $role = $this->model->$property;

        return View::make('admin.components.index-table.columns.user-role', compact('role'))->render();
    }


    private function banned(): string
    {
        $property = $this->property;

        return $this->model->$property ? '<span class="lightgrey-text">' . __('admin/general.no') . '</span>' : __('admin/general.yes');
    }
}