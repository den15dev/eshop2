<?php

use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Common\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/charts', [DashboardController::class, 'charts'])->name('dashboard.charts');

Route::get('/translations', [LanguageController::class, 'adminTranslations'])->name('translations');

Route::get('/ajax/json', [AjaxController::class, 'getJson'])->name('ajax.get.json');
Route::get('/ajax/html', [AjaxController::class, 'getHtml'])->name('ajax.get.html');
Route::post('/ajax', [AjaxController::class, 'post'])->name('ajax.post')->middleware('admin.protection');

Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::get('/orders/table', [OrderController::class, 'table'])->name('orders.table');
Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->whereNumber('id')->name('orders.edit');
Route::middleware('admin.protection')->group(function () {
    Route::put('/orders/{id}', [OrderController::class, 'update'])->whereNumber('id')->name('orders.update');
});

Route::get('/log', [LogController::class, 'index'])->name('log');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/table', [ProductController::class, 'table'])->name('products.table');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->whereNumber('id')->name('products.edit');
Route::middleware('admin.protection')->group(function () {
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->whereNumber('id')->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->whereNumber('id')->name('products.destroy');
});

Route::get('/skus/create', [SkuController::class, 'create'])->name('skus.create');
Route::get('/skus/{id}/edit', [SkuController::class, 'edit'])->whereNumber('id')->name('skus.edit');
Route::middleware('admin.protection')->group(function () {
    Route::post('/skus', [SkuController::class, 'store'])->name('skus.store');
    Route::put('/skus/{id}', [SkuController::class, 'update'])->whereNumber('id')->name('skus.update');
    Route::delete('/skus/{id}', [SkuController::class, 'destroy'])->whereNumber('id')->name('skus.destroy');
});

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->whereNumber('id')->name('categories.edit');
Route::middleware('admin.protection')->group(function () {
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->whereNumber('id')->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->whereNumber('id')->name('categories.destroy');
});

Route::get('/brands', [BrandController::class, 'index'])->name('brands');
Route::get('/brands/table', [BrandController::class, 'table'])->name('brands.table');
Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
Route::get('/brands/{id}/edit', [BrandController::class, 'edit'])->whereNumber('id')->name('brands.edit');
Route::middleware('admin.protection')->group(function () {
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::put('/brands/{id}', [BrandController::class, 'update'])->whereNumber('id')->name('brands.update');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->whereNumber('id')->name('brands.destroy');
});

Route::get('/promos', [PromoController::class, 'index'])->name('promos');
Route::get('/promos/table', [PromoController::class, 'table'])->name('promos.table');
Route::get('/promos/create', [PromoController::class, 'create'])->name('promos.create');
Route::get('/promos/{id}/edit', [PromoController::class, 'edit'])->whereNumber('id')->name('promos.edit');
Route::middleware('admin.protection')->group(function () {
    Route::post('/promos', [PromoController::class, 'store'])->name('promos.store');
    Route::put('/promos/{id}', [PromoController::class, 'update'])->whereNumber('id')->name('promos.update');
    Route::delete('/promos/{id}', [PromoController::class, 'destroy'])->whereNumber('id')->name('promos.destroy');
});

Route::get('/users', [UserController::class, 'index'])->name('users');
Route::get('/users/table', [UserController::class, 'table'])->name('users.table');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->whereNumber('id')->name('users.edit');
Route::middleware('admin.protection')->group(function () {
    Route::put('/users/{id}', [UserController::class, 'update'])->whereNumber('id')->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->whereNumber('id')->name('users.destroy');
});

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
Route::get('/reviews/table', [ReviewController::class, 'table'])->name('reviews.table');
Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->whereNumber('id')->name('reviews.edit');
Route::middleware('admin.protection')->group(function () {
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->whereNumber('id')->name('reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->whereNumber('id')->name('reviews.destroy');
});

Route::get('/stores', [ShopController::class, 'index'])->name('shops');
Route::get('/shops/table', [ShopController::class, 'table'])->name('shops.table');
Route::get('/stores/create', [ShopController::class, 'create'])->name('shops.create');
Route::get('/stores/{id}/edit', [ShopController::class, 'edit'])->whereNumber('id')->name('shops.edit');
Route::middleware('admin.protection')->group(function () {
    Route::post('/stores', [ShopController::class, 'store'])->name('shops.store');
    Route::put('/stores/{id}', [ShopController::class, 'update'])->whereNumber('id')->name('shops.update');
    Route::delete('/stores/{id}', [ShopController::class, 'destroy'])->whereNumber('id')->name('shops.destroy');
});

Route::get('/settings', [SettingController::class, 'edit'])->name('settings');
Route::middleware('admin.protection')->group(function () {
    Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    Route::put('/settings/{id}', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/settings/create', [SettingController::class, 'create'])->name('settings.create');
});
