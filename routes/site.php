<?php

use App\Http\Controllers\Common\CurrencyController;
use App\Http\Controllers\Common\LanguageController;
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
use App\Http\Controllers\Site\TempController;
use App\Http\Controllers\Site\UserNotificationController;
use App\Http\Controllers\Site\UserProfileController;
use Illuminate\Support\Facades\Route;



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

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/new-order/{order_id}', [OrderController::class, 'new'])->whereNumber('order_id')->name('orders.new');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

Route::get('/comparison', [ComparisonController::class, 'index'])->name('comparison');
Route::get('/comparison/popup', [ComparisonController::class, 'popup'])->name('comparison.popup');

Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'store'])->name('profile.store');
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications');
});

require __DIR__.'/auth.php';