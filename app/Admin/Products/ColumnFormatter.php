<?php

namespace App\Admin\Products;

use App\Modules\Products\ValueObjects\Price;
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
        $url = route('admin.skus.edit', $this->model->id);
        $property = $this->property;
        $content = $this->model->$property;

        return View::make('admin.components.index-table.columns.link', compact('url', 'content'))->render();
    }


    private function imageLink()
    {
        $url = route('admin.skus.edit', $this->model->id);
        $imgurl = $this->model->getImage('tn');

        return View::make( 'admin.components.index-table.columns.image-link', compact('url', 'imgurl'))->render();
    }


    private function productLink()
    {
        $url = route('admin.products.edit', $this->model->product_id);
        $property = $this->property;
        $content = $this->model->$property;

        return View::make('admin.components.index-table.columns.link', compact('url', 'content'))->render();
    }


    private function finalPriceFormatted(): string
    {
        return Price::from(
            $this->model->final_price,
            $this->model->currency_id,
            $this->model->currency_id
        )->formatted_full;
    }


    private function dateStatus(): string
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