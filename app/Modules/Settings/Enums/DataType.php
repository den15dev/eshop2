<?php

namespace App\Modules\Settings\Enums;

enum DataType: string
{
    case String = 'string';
    case Integer = 'integer';
    case Boolean = 'boolean';
    case Array = 'array';
}
