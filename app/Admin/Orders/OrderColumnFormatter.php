<?php

namespace App\Admin\Orders;

use App\Admin\IndexTable\ColumnFormatter;
use App\Modules\Products\ValueObjects\Price;
use Illuminate\Support\Facades\View;

final class OrderColumnFormatter extends ColumnFormatter
{
    protected function status()
    {
        $property = $this->property;
        $status = $this->model->$property->value;
        $description = $this->model->$property->description();

        return View::make('admin.components.index-table.columns.order-status', compact('status', 'description'))->render();
    }


    protected function enumDescription(): string
    {
        $property = $this->property;

        return $this->model->$property->description();
    }


    protected function paymentStatus()
    {
        $property = $this->property;
        $status = $this->model->$property->value;
        $description = $this->model->$property->description();

        return View::make('admin.components.index-table.columns.payment-status', compact('status', 'description'))->render();
    }


    protected function sumFormatted(): string
    {
        $property = $this->property;

        return $this->model->$property
            ? Price::from(
                $this->model->$property,
                $this->model->currency_id,
                $this->model->currency_id
            )->formatted_full
            : '-';
    }
}