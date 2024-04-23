<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\NodeController;
use App\Models\Node;
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

Route::get('/book/name/{title}', [BookController::class, 'getBookByTitle']);

Route::get('/elements/book/{bookId}', [ElementController::class, 'getElementsForBook']);
Route::get('/elements/book/name/{title}', [ElementController::class, 'getElementsForBookWithName']);

Route::get('/nodes/element/{elementId}', [NodeController::class, 'getNodesForElement']);
Route::get('/nodes/element/name/{name}', [NodeController::class, 'getNodesForElementWithName']);
Route::post('/node/parent-node/{parentNodeId}', [NodeController::class, 'createChildNode']);
Route::get('/child-nodes/{parentNodeId}', [NodeController::class, 'getChildNodes']);
Route::get('/parent-node/{childNodeId}', [NodeController::class, 'getParentNode']);
