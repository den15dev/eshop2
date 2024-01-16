<?php

namespace App\View\Composers;

use App\Modules\Categories\CategoryService;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Languages\LanguageService;
use App\Modules\Settings\Models\Setting;
use Illuminate\View\View;

class LayoutComposer
{
    public function compose(View $view): void
    {
        $currencies = CurrencyService::getAll();
        $languages = LanguageService::getActive();
        $categories = (new CategoryService())->buildCategoryTree();

        $settings = Setting::getAll();
        $phone = $settings->firstWhere('name', 'phone')->val;
        $phone_tel = str_replace([' ', '(', ')', '-'], '', $phone);

        $view->with(compact(
            'currencies',
            'languages',
            'phone',
            'phone_tel',
            'categories',
        ));
    }
}