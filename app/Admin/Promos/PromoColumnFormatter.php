<?php

namespace App\Admin\Promos;

use App\Admin\IndexTable\ColumnFormatter;
use Illuminate\Support\Facades\View;

final class PromoColumnFormatter extends ColumnFormatter
{
    protected function promoImage(): string
    {
        $imgurl = $this->model->getImageURL('sm');
        $img_height = 60;

        return View::make( 'admin.components.index-table.columns.image', compact('imgurl', 'img_height'))->render();
    }


    protected function percent(): string
    {
        $property = $this->property;
        return $this->model->$property . '%';
    }


    protected function dateFormat(): string
    {
        $start = $this->model->starts_at;
        $end = $this->model->ends_at;
        $property = $this->property;
        $date = $this->model->$property->isoFormat('Y-MM-DD') ?? '-';

        $status = null;
        if ($start->isFuture()) {
            $status = 'scheduled';
        } elseif ($end?->isPast()) {
            $status = 'inactive';
        }

        return $status
            ? View::make('admin.components.index-table.columns.date-status', compact('status', 'date'))->render()
            : $date;
    }
}