<?php

namespace App\View\Composers;

use App\Admin\Orders\OrderService;
use App\Modules\Languages\LanguageService;
use Illuminate\View\View;

class AdminLayoutComposer
{
    public function compose(View $view): void
    {
        $languages = LanguageService::getActive();
        $new_orders_num = OrderService::getNewNum();

        $view->with(compact(
            'languages',
            'new_orders_num',
        ));
    }
}
