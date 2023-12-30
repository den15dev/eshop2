<?php

namespace App\View\Composers;

use App\Modules\Currencies\Models\Currency;
use App\Modules\Languages\Models\Language;
use App\Modules\Settings\Models\Setting;
use Illuminate\View\View;

class LayoutComposer
{
    public function compose(View $view): void
    {
        $currencies = Currency::getAll();
        $languages = Language::getActive();

        $settings = Setting::getAll();
        $phone = $settings->firstWhere('name', 'phone')->val;
        $phone_tel = str_replace([' ', '(', ')', '-'], '', $phone);

        $view->with(compact(
            'currencies',
            'languages',
            'phone',
            'phone_tel'
        ));
    }
}