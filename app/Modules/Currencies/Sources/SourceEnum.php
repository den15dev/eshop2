<?php

namespace App\Modules\Currencies\Sources;

enum SourceEnum: string
{
    case Manual = 'manual';
    case Cbrf = 'cbrf';
}
