<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\TempController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\CatalogController;
use App\Http\Controllers\Admin\DashboardController;



Route::get('/temp', [TempController::class, 'temp'])->name('temp');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog/{category}', [CatalogController::class, 'index'])->name('catalog');


Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');