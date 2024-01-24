<?php

use App\Http\Controllers\Common\CurrencyController;
use App\Http\Controllers\Common\LanguageController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\CatalogController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\OrderController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\PromoController;
use App\Http\Controllers\Site\ReviewController;
use App\Http\Controllers\Site\TempController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/language', LanguageController::class)->name('language');
Route::post('/currency', CurrencyController::class)->name('currency');

Route::get('/temp', [TempController::class, 'temp'])->name('temp');

Route::post('/catalog/preferences', [CatalogController::class, 'setLayout'])->name('catalog.preferences');
Route::get('/catalog/{category}', [CatalogController::class, 'index'])->name('catalog');
Route::get('/catalog/{category}/{product}', [ProductController::class, 'show'])->name('product');
Route::get('/catalog/{category}/{product}/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::post('/catalog/{category}/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.add');

Route::get('/promo/{promo}', [PromoController::class, 'show'])->name('promo');

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/new-order/{order_id}', [OrderController::class, 'new'])->whereNumber('order_id')->name('orders.new');

require __DIR__.'/auth.php';