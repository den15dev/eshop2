<?php

namespace App\Admin\Products;

use App\Modules\Products\Models\Sku;
use App\Modules\Products\ValueObjects\Price;
use Illuminate\Support\Facades\View;

class ColumnFormatter
{
    public function __construct(
        public string $format
    ){}


    public function get(Sku $sku): string
    {
        $method = $this->format;

        return $this->$method($sku);
    }


    private function nameLink(Sku $sku)
    {
        $url = route('admin.skus.edit', $sku->id);
        $content = $sku->name;

        return View::make('admin.components.index-table.columns.link', compact('url', 'content'))->render();
    }


    private function imageLink(Sku $sku)
    {
        $url = route('admin.skus.edit', $sku->id);
        $imgurl = $sku->image_sm;

        return View::make( 'admin.components.index-table.columns.image-link', compact('url', 'imgurl'))->render();
    }


    private function productLink(Sku $sku)
    {
        $url = route('admin.products.edit', $sku->product_id);
        $content = $sku->product_name;

        return View::make('admin.components.index-table.columns.link', compact('url', 'content'))->render();
    }


    private function finalPriceFormatted(Sku $sku): string
    {
        return Price::formatToCurrency($sku->final_price, $sku->currency_id);
    }


    private function scheduled(Sku $sku): string
    {
        $from = $sku->available_from;

        return $from->isFuture()
            ? View::make('admin.components.index-table.columns.scheduled', compact('from'))->render()
            : $from;
    }
}