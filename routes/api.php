<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\NodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('books', BookController::class);
Route::apiResource('elements', ElementController::class);
Route::apiResource('nodes', NodeController::class);

Route::get('/elements/book/{bookId}', [ElementController::class, 'getElementsForBook']);
