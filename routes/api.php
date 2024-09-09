<?php

use App\Api\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/getContent/{path}', [IndexController::class, 'index']);
Route::post('/create', [IndexController::class, 'create']);
Route::post('/update', [IndexController::class, 'update']);
