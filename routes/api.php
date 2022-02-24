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
Route::get('/category/{id}',[\App\Http\Controllers\CategoryController::class,'getCategory'])->whereNumber('id');
Route::put('/category',[\App\Http\Controllers\CategoryController::class,'createCategory']);
Route::patch('/category/{id}',[\App\Http\Controllers\CategoryController::class,'updateCategory'])->whereNumber('id');
Route::delete('/category/{id}',[\App\Http\Controllers\CategoryController::class,'deleteCategory'])->whereNumber('id');

//Macro related routes
Route::get('/macro',[\App\Http\Controllers\MacroController::class,'getAllMacros']);
Route::get('/macro/{id}',[\App\Http\Controllers\MacroController::class,'getMacro'])->whereNumber('id');
Route::put('/macro',[\App\Http\Controllers\MacroController::class,'createMacro']);
Route::patch('/macro/{id}',[\App\Http\Controllers\MacroController::class,'updateMacro'])->whereNumber('id');
Route::delete('/macro/{id}',[\App\Http\Controllers\MacroController::class,'deleteMacro'])->whereNumber('id');

//Equipment related routes
Route::get('/equipment',[\App\Http\Controllers\EquipmentController::class,'getAllEquipments']);
Route::get('/equipment/{id}',[\App\Http\Controllers\EquipmentController::class,'getEquipment'])->whereNumber('id');
Route::put('/equipment',[\App\Http\Controllers\EquipmentController::class,'createEquipment']);
Route::patch('/equipment/{id}',[\App\Http\Controllers\EquipmentController::class,'updateEquipment'])->whereNumber('id');
Route::delete('/equipment/{id}',[\App\Http\Controllers\EquipmentController::class,'deleteEquipment'])->whereNumber('id');

//Exercise related routes
Route::get('/exercise',[\App\Http\Controllers\ExerciseController::class,'getAllExercises']);
Route::get('/exercise/{id}',[\App\Http\Controllers\ExerciseController::class,'getExercise'])->whereNumber('id');
Route::put('/exercise',[\App\Http\Controllers\ExerciseController::class,'createExercise']);
Route::patch('/exercise/{id}',[\App\Http\Controllers\ExerciseController::class,'updateExercise'])->whereNumber('id');
Route::delete('/exercise/{id}',[\App\Http\Controllers\ExerciseController::class,'deleteExercise'])->whereNumber('id');

//Exercise related routes
Route::get('/workout',[\App\Http\Controllers\WorkoutController::class,'getAllWorkouts']);
Route::get('/workout/{id}',[\App\Http\Controllers\WorkoutController::class,'getWorkout'])->whereNumber('id');
Route::put('/workout',[\App\Http\Controllers\WorkoutController::class,'createWorkout']);
Route::patch('/workout/{id}',[\App\Http\Controllers\WorkoutController::class,'updateWorkout'])->whereNumber('id');
Route::delete('/workout/{id}',[\App\Http\Controllers\WorkoutController::class,'deleteWorkout'])->whereNumber('id');

Route::get('/workout/exercises/{id}',[\App\Http\Controllers\WorkoutExerciseController::class,'GetWorkoutsExercises'])->whereNumber('id');
Route::put('/workout/exercises/',[\App\Http\Controllers\WorkoutExerciseController::class,'AddNewExercise']);
Route::patch('/workout/exercises/',[\App\Http\Controllers\WorkoutExerciseController::class,'UpdateWorkoutsExercises']);
Route::delete('/workout/exercises/',[\App\Http\Controllers\WorkoutExerciseController::class,'DeleteWorkoutsExercises']);
