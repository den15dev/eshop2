<?php

namespace App\Modules\Currencies\Sources;

use Illuminate\Support\Collection;

abstract class Source
{
    abstract public function enum(): SourceEnum;

    abstract public function getRates(): Collection;
}