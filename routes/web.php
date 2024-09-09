<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('{path}', [HomeController::class, 'xxxxxx']);
Route::get('xxxxxx/{path}', [HomeController::class, 'xxxxxx']);
