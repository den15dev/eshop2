<?php

namespace App\Admin\Brands;

use App\Modules\Brands\Models\Brand;
use Illuminate\Support\Facades\View;

class ColumnFormatter
{
    public function __construct(
        public string $format
    ){}


    public function get(Brand $brand): string
    {
        $method = $this->format;

        return $this->$method($brand);
    }


    private function nameLink(Brand $brand)
    {
        $url = route('admin.brands.edit', $brand->id);
        $content = $brand->name;

        return View::make('admin.components.index-table.columns.link', compact('url', 'content'))->render();
    }


    private function imageLink(Brand $brand)
    {
        $url = route('admin.brands.edit', $brand->id);
        $imgurl = $brand->image_url;

        return View::make( 'admin.components.index-table.columns.image-link-brand', compact('url', 'imgurl'))->render();
    }
}