<?php

namespace App\View\Composers;

use App\Modules\Languages\LanguageService;
use Illuminate\View\View;

class AdminLayoutComposer
{
    public function compose(View $view): void
    {
        $languages = LanguageService::getActive();

        $view->with(compact('languages'));
    }
}