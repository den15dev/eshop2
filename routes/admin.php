<?php

use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Common\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
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

Route::get('/logs', [LogController::class, 'index'])->name('logs');

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

Route::get('/promos', IndexController::class)->name('promos');

Route::get('/promos', [PromoController::class, 'index'])->name('promos');
Route::get('/promos/table', [PromoController::class, 'table'])->name('promos.table');
Route::get('/promos/create', [PromoController::class, 'create'])->name('promos.create');
Route::get('/promos/{id}/edit', [PromoController::class, 'edit'])->whereNumber('id')->name('promos.edit');
Route::middleware('admin.protection')->group(function () {
    Route::post('/promos', [PromoController::class, 'store'])->name('promos.store');
    Route::put('/promos/{id}', [PromoController::class, 'update'])->whereNumber('id')->name('promos.update');
    Route::delete('/promos/{id}', [PromoController::class, 'destroy'])->whereNumber('id')->name('promos.destroy');
});

Route::get('/users', IndexController::class)->name('users');

Route::get('/reviews', IndexController::class)->name('reviews');

Route::get('/stores', IndexController::class)->name('stores');
