<?php

namespace App\Admin\Orders;

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


    private function status()
    {
        $property = $this->property;
        $status = $this->model->$property->value;
        $description = $this->model->$property->description();

        return View::make('admin.components.index-table.columns.order-status', compact('status', 'description'))->render();
    }


    private function paymentStatus()
    {
        $property = $this->property;
        $status = $this->model->$property->value;
        $description = $this->model->$property->description();

        return View::make('admin.components.index-table.columns.payment-status', compact('status', 'description'))->render();
    }


    private function sumFormatted(): string
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