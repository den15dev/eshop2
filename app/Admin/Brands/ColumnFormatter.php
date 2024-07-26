<?php

namespace App\Admin\Brands;

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


    private function brandImage(): string
    {
        $imgurl = $this->model->image_url;
        $img_height = 20;

        return View::make( 'admin.components.index-table.columns.image', compact('imgurl', 'img_height'))->render();
    }
}