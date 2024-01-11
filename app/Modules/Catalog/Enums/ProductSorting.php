<?php

namespace App\Modules\Catalog\Enums;

enum ProductSorting: string
{
    case New = 'new';
    case Cheap = 'cheap';
    case Expensive = 'expensive';
    case Popular = 'popular';
    case Discounted = 'discounted';


    public static function getDescription(self $sorting_type): string
    {
        return match ($sorting_type) {
            self::New => __('catalog.layout_settings.sort.' . self::New->value),
            self::Cheap => __('catalog.layout_settings.sort.' . self::Cheap->value),
            self::Expensive => __('catalog.layout_settings.sort.' . self::Expensive->value),
            self::Popular => __('catalog.layout_settings.sort.' . self::Popular->value),
            self::Discounted => __('catalog.layout_settings.sort.' . self::Discounted->value),
        };
    }
}
