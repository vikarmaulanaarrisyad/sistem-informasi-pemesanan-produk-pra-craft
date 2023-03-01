<?php

use App\Http\Controllers\API\{
    ApiCategoryController,
    ApiProductController,
};
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories/data', [ApiCategoryController::class, 'getDataCategory'])->name('api.data.category');
Route::get('/categories/search', [ApiCategoryController::class, 'ajaxSearch'])->name('api.search.product');
Route::get('/product/data', [ApiProductController::class, 'getDataProduct'])->name('api.data.product');
