<?php

namespace App\Admin\Users;

use App\Admin\IndexTable\ColumnFormatter;
use Illuminate\Support\Facades\View;

final class UserColumnFormatter extends ColumnFormatter
{
    protected function role()
    {
        $property = $this->property;
        $role = $this->model->$property;

        return View::make('admin.components.index-table.columns.user-role', compact('role'))->render();
    }


    protected function banned(): string
    {
        $property = $this->property;

        return $this->model->$property ? '<span class="lightgrey-text">' . __('admin/general.no') . '</span>' : __('admin/general.yes');
    }
}