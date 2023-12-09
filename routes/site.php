<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\TempController;
use App\Http\Controllers\Site\LanguageController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\CatalogController;


Route::get('/temp', [TempController::class, 'temp'])->name('temp');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/language', LanguageController::class)->name('language');

Route::get('/catalog/{category}', [CatalogController::class, 'index'])->name('catalog');
