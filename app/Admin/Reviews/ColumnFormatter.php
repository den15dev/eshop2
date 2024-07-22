<?php

namespace App\Admin\Reviews;

use Illuminate\Database\Eloquent\Model;

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


    private function clipText(): string
    {
        $max_symbols = 70;
        $property = $this->property;
        $text = $this->model->$property;

        if (!$text) return '-';

        if (mb_strlen($text) > $max_symbols) {
            $text = mb_substr($text, 0, $max_symbols) . '...';
        }

        return $text;
    }
}