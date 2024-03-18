<?php

namespace App\Modules\Currencies\Sources;

class SourceFactory
{
    public static function make(SourceEnum $source): Source
    {
        return match ($source) {
            SourceEnum::Manual => app(ManualSource::class),
            SourceEnum::Cbrf => app(CbrfSource::class),
        };
    }
}