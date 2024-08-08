<?php

namespace App\Admin\IndexTable;

use Illuminate\Database\Eloquent\Model;

abstract class ColumnFormatter
{
    protected Model $model;
    protected string $property;


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
}