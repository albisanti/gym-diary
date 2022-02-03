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

//Category related routes
Route::get('/category',[\App\Http\Controllers\CategoryController::class,'getAllCategories']);
Route::get('/category/{id}',[\App\Http\Controllers\CategoryController::class,'getCategory']);
Route::put('/category',[\App\Http\Controllers\CategoryController::class,'createCategory']);
Route::patch('/category/{id}',[\App\Http\Controllers\CategoryController::class,'updateCategory']);
Route::delete('/category/{id}',[\App\Http\Controllers\CategoryController::class,'deleteCategory']);

//Macro related routes
Route::get('/macro',[\App\Http\Controllers\MacroController::class,'getAllMacros']);
Route::get('/macro/{id}',[\App\Http\Controllers\MacroController::class,'getMacro']);
Route::put('/macro',[\App\Http\Controllers\MacroController::class,'createMacro']);
Route::patch('/macro/{id}',[\App\Http\Controllers\MacroController::class,'updateMacro']);
Route::delete('/macro/{id}',[\App\Http\Controllers\MacroController::class,'deleteMacro']);

//Equipment related routes
Route::get('/equipment',[\App\Http\Controllers\EquipmentController::class,'getAllEquipments']);
Route::get('/equipment/{id}',[\App\Http\Controllers\EquipmentController::class,'getEquipment']);
Route::put('/equipment',[\App\Http\Controllers\EquipmentController::class,'createEquipment']);
Route::patch('/equipment/{id}',[\App\Http\Controllers\EquipmentController::class,'updateEquipment']);
Route::delete('/equipment/{id}',[\App\Http\Controllers\EquipmentController::class,'deleteEquipment']);
