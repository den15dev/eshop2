<?php

namespace App\Admin\Promos;

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


    private function promoImage(): string
    {
        $imgurl = $this->model->getImageURL('sm');
        $img_height = 60;

        return View::make( 'admin.components.index-table.columns.image', compact('imgurl', 'img_height'))->render();
    }


    private function percent(): string
    {
        $property = $this->property;
        return $this->model->$property . '%';
    }


    private function dateFormat(): string
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