<?php

namespace App\Modules\Currencies\Sources;

use Illuminate\Support\Collection;

class ManualSource extends Source
{
    public function enum(): SourceEnum
    {
        return SourceEnum::Manual;
    }

    public function getRates(): Collection
    {
        return new Collection();
    }
}