<?php

namespace App\View\Composers;

use App\Models\Language;
use App\Models\Setting;
use Illuminate\View\View;

class LayoutComposer
{
    public function compose(View $view): void
    {
        $languages = Language::getActive();

        $settings = Setting::getAll();
        $phone = $settings->firstWhere('name', 'phone')->val;
        $phone_tel = str_replace([' ', '(', ')', '-'], '', $phone);

        $view->with(compact(
            'languages',
            'phone',
            'phone_tel'
        ));
    }
}