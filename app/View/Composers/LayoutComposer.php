<?php

namespace App\View\Composers;

use App\Modules\Categories\CategoryService;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\ComparisonService;
use App\Modules\Products\FavoriteService;
use App\Modules\Settings\Models\Setting;
use Illuminate\View\View;

class LayoutComposer
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly ComparisonService $comparisonService,
    ) {}

    public function compose(View $view): void
    {
        $currencies = CurrencyService::getAll();
        $languages = LanguageService::getActive();
        $categories = $this->categoryService->buildCategoryTree();

        $comparisonData = ComparisonService::get();
        $comparison_products = $this->comparisonService->getPopupProducts();
        $is_popup_collapsed = $comparisonData?->is_popup_collapsed;

        $favorites_num = FavoriteService::count();

        $settings = Setting::getAll();
        $phone = $settings->firstWhere('name', 'phone')->val;
        $phone_tel = str_replace([' ', '(', ')', '-'], '', $phone);

        $view->with(compact(
            'currencies',
            'languages',
            'phone',
            'phone_tel',
            'categories',
            'is_popup_collapsed',
            'comparison_products',
            'favorites_num',
        ));
    }
}