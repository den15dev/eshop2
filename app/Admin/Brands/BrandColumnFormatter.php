<?php

namespace App\Admin\Brands;

use App\Admin\IndexTable\ColumnFormatter;
use Illuminate\Support\Facades\View;

final class BrandColumnFormatter extends ColumnFormatter
{
    protected function brandImage(): string
    {
        $imgurl = $this->model->image_url;
        $img_height = 20;

        return View::make( 'admin.components.index-table.columns.image', compact('imgurl', 'img_height'))->render();
    }
}