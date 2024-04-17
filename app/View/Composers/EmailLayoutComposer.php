<?php

namespace App\View\Composers;

use Illuminate\View\View;

class EmailLayoutComposer
{
    public function compose(View $view): void
    {
        $logo = app()->getLocale() === 'ru' ? 'logo_ru_160.png' : 'logo_en_160.png';
        $home_url = preg_replace('/\/[a-z]{2}\/?$/', '', route('home'));
        $footer_home_link = '<a href="' . $home_url . '" style="color: #716EF6;">' . __('general.app_name') . '</a>';

        $view->with(compact(
            'logo',
            'home_url',
            'footer_home_link',
        ));
    }
}