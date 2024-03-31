<?php

namespace App\View\Composers;

use App\Modules\Cart\CartService;
use App\Modules\Catalog\ComparisonService;
use App\Modules\Categories\CategoryService;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Favorites\FavoriteService;
use App\Modules\Languages\LanguageService;
use App\Modules\StaticPages\Models\StaticPageParam;
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

        $cart_items_num = count(CartService::getCart());

        $comparisonData = ComparisonService::get();
        $comparison_products = $this->comparisonService->getPopupProducts();
        $is_popup_collapsed = $comparisonData?->is_popup_collapsed;

        $favorites_num = FavoriteService::count();

        $settings = StaticPageParam::getGeneral();
        $phone = $settings->firstWhere('name', 'phone')->val;
        $phone_tel = str_replace([' ', '(', ')', '-'], '', $phone);

        $view->with(compact(
            'currencies',
            'languages',
            'phone',
            'phone_tel',
            'categories',
            'cart_items_num',
            'is_popup_collapsed',
            'comparison_products',
            'favorites_num',
        ));
    }
}