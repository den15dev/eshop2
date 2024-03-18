<?php

namespace App\Modules\Currencies\Sources;

class SourceRate
{
    public function __construct(
        public string $currency_id,
        public string $value,
    ) {}
}