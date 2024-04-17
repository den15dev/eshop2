<?php

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
use App\Http\Controllers\Site\ReactionController;
use App\Http\Controllers\Site\ReviewController;
use App\Http\Controllers\Site\SearchController;
use App\Http\Controllers\Site\ShopController;
use App\Http\Controllers\Site\StaticPages\DeliveryController;
use App\Http\Controllers\Site\StaticPages\WarrantyController;
use App\Http\Controllers\Site\Temp\TempController;
use App\Http\Controllers\Site\UserNotificationController;
use App\Http\Controllers\Site\UserProfileController;
use App\Http\Middleware\CheckOrderOwner;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/language', [LanguageController::class, 'set'])->name('language.set');
Route::get('/translations', [LanguageController::class, 'translations'])->name('translations');
Route::post('/currency', CurrencyController::class)->name('currency');

Route::get('/catalog/{category}', [CatalogController::class, 'index'])->name('catalog');
Route::get('/catalog/{category}/{product}', [ProductController::class, 'show'])->name('product');
Route::get('/catalog/{category}/{product}/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/catalog/{category}/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.add');

Route::post('/reaction/store', [ReactionController::class, 'store'])->middleware('auth')->name('reaction.store');

Route::get('/promo/{promo}', [PromoController::class, 'show'])->name('promo');

Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brand');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'destroy'])->name('cart.clear');

Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

Route::get('/new-order/{order_id}', [OrderController::class, 'new'])
    ->whereNumber('order_id')
    ->middleware([CheckOrderOwner::class])
    ->name('orders.new');

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
    Route::post('/notification/read', [UserNotificationController::class, 'update'])->name('notification.read');
});

Route::get('/stores', ShopController::class)->name('stores');

// ---------- Static pages ----------

Route::get('/delivery', DeliveryController::class)->name('delivery');
Route::get('/warranty', WarrantyController::class)->name('warranty');

require __DIR__.'/auth.php';


// ---------- TEMP FOR DELETE ----------

Route::get('/temp', [TempController::class, 'temp'])->name('temp');
Route::get('/notification', function () {
    /*
    $order = \App\Modules\Orders\Models\Order::find(1);
    $user = $order->user;

    return (new \App\Notifications\OrderSent($order))->toMail($user);
    */

    $user = \Illuminate\Support\Facades\Auth::user();
    $url = 'http://eshop2.local/en/verify-email/1/8d94e9653bd4ed083d6d8af236837e40517bc229?expires=1705444022&signature=774ac50907eb9124f5221c57d4e4ecd352229e3db93640c39a295aa816219c89';

    return new \App\Mail\ResetPasswordMailable($user, $url);
});

// -----------------------------------