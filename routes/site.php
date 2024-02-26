<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Common\CurrencyController;
use App\Http\Controllers\Common\LanguageController;
use App\Http\Controllers\Site\BrandController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\CatalogController;
use App\Http\Controllers\Site\ComparisonController;
use App\Http\Controllers\Site\FavoriteController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\OrderController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\PromoController;
use App\Http\Controllers\Site\ReviewController;
use App\Http\Controllers\Site\SearchController;
use App\Http\Controllers\Site\ShopController;
use App\Http\Controllers\Site\TempController;
use App\Http\Controllers\Site\UserNotificationController;
use App\Http\Controllers\Site\UserProfileController;
use App\Http\Controllers\Site\StaticPages\DeliveryController;
use App\Http\Controllers\Site\StaticPages\WarrantyController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/language', [LanguageController::class, 'set'])->name('language.set');
Route::get('/translations', [LanguageController::class, 'translations'])->name('translations');
Route::post('/currency', CurrencyController::class)->name('currency');

Route::get('/temp', [TempController::class, 'temp'])->name('temp');

Route::get('/catalog/{category}', [CatalogController::class, 'index'])->name('catalog');
Route::get('/catalog/{category}/{product}', [ProductController::class, 'show'])->name('product');
Route::get('/catalog/{category}/{product}/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/catalog/{category}/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.add');

Route::get('/promo/{promo}', [PromoController::class, 'show'])->name('promo');

Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brand');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/new-order/{order_id}', [OrderController::class, 'new'])->whereNumber('order_id')->name('orders.new');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/dropdown', [SearchController::class, 'dropdown'])->name('search.dropdown');

Route::get('/comparison', [ComparisonController::class, 'index'])->name('comparison');
Route::get('/comparison/popup', [ComparisonController::class, 'popup'])->name('comparison.popup');

Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'store'])->name('profile.store');
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications');
});

Route::get('/shops', ShopController::class)->name('shops');

// ---------- Static pages ----------

Route::get('/delivery', DeliveryController::class)->name('delivery');
Route::get('/warranty', WarrantyController::class)->name('warranty');

require __DIR__.'/auth.php';