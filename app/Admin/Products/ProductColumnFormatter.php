<?php

namespace App\Admin\Products;

use App\Admin\IndexTable\ColumnFormatter;
use App\Modules\Products\ValueObjects\Price;
use Illuminate\Support\Facades\View;

final class ProductColumnFormatter extends ColumnFormatter
{
    protected function nameLink()
    {
        $url = route('admin.skus.edit', $this->model->id);
        $property = $this->property;
        $content = $this->model->$property;

        return View::make('admin.components.index-table.columns.link', compact('url', 'content'))->render();
    }


    protected function imageLink()
    {
        $url = route('admin.skus.edit', $this->model->id);
        $imgurl = $this->model->getImageURL('tn');

        return View::make('admin.components.index-table.columns.image-link', compact('url', 'imgurl'))->render();
    }


    protected function productLink()
    {
        $url = route('admin.products.edit', $this->model->product_id);
        $property = $this->property;
        $content = $this->model->$property;

        return View::make('admin.components.index-table.columns.link', compact('url', 'content'))->render();
    }


    protected function finalPriceFormatted(): string
    {
        return Price::from(
            $this->model->final_price,
            $this->model->currency_id,
            $this->model->currency_id
        )->formatted_full;
    }


    protected function dateStatus(): string
    {
        $from = $this->model->available_from;
        $until = $this->model->available_until;
        $property = $this->property;
        $date = $this->model->$property ?? '-';

        $status = null;
        if ($from->isFuture()) {
            $status = 'scheduled';
        } elseif ($until?->isPast()) {
            $status = 'inactive';
        }

        return $status
            ? View::make('admin.components.index-table.columns.date-status', compact('status', 'date'))->render()
            : $date;
    }
}