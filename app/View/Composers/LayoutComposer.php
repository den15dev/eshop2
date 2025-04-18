<?php

namespace App\View\Composers;

use App\Modules\Cart\CartService;
use App\Modules\Catalog\ComparisonService;
use App\Modules\Categories\CategoryService;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Favorites\FavoriteService;
use App\Modules\Languages\LanguageService;
use App\Modules\Orders\OrderService;
use App\Modules\Settings\SettingService;
use App\Modules\StaticPages\Models\StaticPageParam;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LayoutComposer
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly ComparisonService $comparisonService,
    ){}

    public function compose(View $view): void
    {
        $currencies = CurrencyService::getAll();
        $languages = LanguageService::getActive();
        $categories = $this->categoryService->buildCategoryTree();

        $favorites_num = FavoriteService::count();
        $cart_items_num = count(CartService::getCart());
        $orders_count = OrderService::countOrders();
        $unread_notifications_num = Auth::user()?->unreadNotifications->count();

        $comparisonData = ComparisonService::get();
        $comparison_skus = $this->comparisonService->getPopupSkus();
        $is_popup_collapsed = $comparisonData?->is_popup_collapsed;

        $settings = StaticPageParam::getGeneral();
        $phone = $settings->firstWhere('name', 'phone')?->val;
        $phone_tel = str_replace([' ', '(', ')', '-'], '', $phone);

        $isRegistrationAllowed = SettingService::get('allow_registration');

        $view->with(compact(
            'currencies',
            'languages',
            'phone',
            'phone_tel',
            'categories',
            'cart_items_num',
            'orders_count',
            'unread_notifications_num',
            'is_popup_collapsed',
            'comparison_skus',
            'favorites_num',
            'isRegistrationAllowed',
        ));
    }
}
