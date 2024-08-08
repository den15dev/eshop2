<?php

namespace App\Admin\Reviews;

use App\Admin\IndexTable\ColumnFormatter;

final class ReviewColumnFormatter extends ColumnFormatter
{
    protected function clipText(): string
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