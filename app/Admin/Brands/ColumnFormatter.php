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


    private function nameLink()
    {
        $url = route('admin.brands.edit', $this->model->id);
        $property = $this->property;
        $content = $this->model->$property;

        return View::make('admin.components.index-table.columns.link', compact('url', 'content'))->render();
    }


    private function imageLink()
    {
        $url = route('admin.brands.edit', $this->model->id);
        $imgurl = $this->model->image_url;

        return View::make( 'admin.components.index-table.columns.image-link-brand', compact('url', 'imgurl'))->render();
    }
}