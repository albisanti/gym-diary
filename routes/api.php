<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/category',[\App\Http\Controllers\CategoryController::class,'getAllCategories']);
Route::get('/category/{id}',[\App\Http\Controllers\CategoryController::class,'getCategory']);
Route::put('/category',[\App\Http\Controllers\CategoryController::class,'createCategory']);
Route::patch('/category/{id}',[\App\Http\Controllers\CategoryController::class,'updateCategory']);
Route::delete('/category/{id}',[\App\Http\Controllers\CategoryController::class,'deleteCategory']);
