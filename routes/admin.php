<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SkuController;
use App\Http\Controllers\Common\LanguageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/translations', [LanguageController::class, 'adminTranslations'])->name('translations');

//Route::get('/search', [IndexController::class, 'search'])->name('search');

Route::get('/logs', [LogController::class, 'index'])->name('logs');

Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/table', [ProductController::class, 'table'])->name('products.table');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->whereNumber('id')->name('products.edit');

Route::get('/skus/create', [SkuController::class, 'create'])->name('skus.create');
Route::get('/skus/{id}/edit', [SkuController::class, 'edit'])->whereNumber('id')->name('skus.edit');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');

Route::get('/brands', IndexController::class)->name('brands');

Route::get('/promos', IndexController::class)->name('promos');

Route::get('/users', IndexController::class)->name('users');

Route::get('/reviews', IndexController::class)->name('reviews');

Route::get('/orders', IndexController::class)->name('orders');

Route::get('/stores', IndexController::class)->name('stores');
