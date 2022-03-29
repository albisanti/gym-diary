<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MacroController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\WorkoutExerciseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;

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
Route::get('/category',[CategoryController::class,'getAllCategories']);
Route::get('/category/{id}',[CategoryController::class,'getCategory'])->whereNumber('id');
Route::put('/category',[CategoryController::class,'createCategory']);
Route::patch('/category/{id}',[CategoryController::class,'updateCategory'])->whereNumber('id');
Route::delete('/category/{id}',[CategoryController::class,'deleteCategory'])->whereNumber('id');

//Macro related routes
Route::get('/macro',[MacroController::class,'getAllMacros']);
Route::get('/macro/{id}',[MacroController::class,'getMacro'])->whereNumber('id');
Route::put('/macro',[MacroController::class,'createMacro']);
Route::patch('/macro/{id}',[MacroController::class,'updateMacro'])->whereNumber('id');
Route::delete('/macro/{id}',[MacroController::class,'deleteMacro'])->whereNumber('id');

//Equipment related routes
Route::get('/equipment',[EquipmentController::class,'getAllEquipments']);
Route::get('/equipment/{id}',[EquipmentController::class,'getEquipment'])->whereNumber('id');
Route::put('/equipment',[EquipmentController::class,'createEquipment']);
Route::patch('/equipment/{id}',[EquipmentController::class,'updateEquipment'])->whereNumber('id');
Route::delete('/equipment/{id}',[EquipmentController::class,'deleteEquipment'])->whereNumber('id');

//Exercise related routes
Route::get('/exercise',[ExerciseController::class,'getAllExercises']);
Route::get('/exercise/{id}',[ExerciseController::class,'getExercise'])->whereNumber('id');
Route::put('/exercise',[ExerciseController::class,'createExercise']);
Route::patch('/exercise/{id}',[ExerciseController::class,'updateExercise'])->whereNumber('id');
Route::delete('/exercise/{id}',[ExerciseController::class,'deleteExercise'])->whereNumber('id');

//Exercise related routes
Route::get('/workout',[WorkoutController::class,'getAllWorkouts']);
Route::get('/workout/{id}',[WorkoutController::class,'getWorkout'])->whereNumber('id');
Route::put('/workout',[WorkoutController::class,'createWorkout']);
Route::patch('/workout/{id}',[WorkoutController::class,'updateWorkout'])->whereNumber('id');
Route::delete('/workout/{id}',[WorkoutController::class,'deleteWorkout'])->whereNumber('id');

//Workouts' exercises related routes
Route::get('/workout/exercises/{id}',[WorkoutExerciseController::class,'GetWorkoutsExercises'])->whereNumber('id');
Route::put('/workout/exercises/',[WorkoutExerciseController::class,'AddNewExercise']);
Route::patch('/workout/exercises/',[WorkoutExerciseController::class,'UpdateWorkoutsExercises']);
Route::delete('/workout/exercises/',[WorkoutExerciseController::class,'DeleteWorkoutsExercises']);

//Feedback releted routes
Route::get('/feedback/{workoutId}',[FeedbackController::class,'GetFeedbackFromWorkoutId'])->whereNumber('workoutId');
Route::put('/feedback',[FeedbackController::class,'AddNewFeedback']);
Route::patch('/feedback/{id}',[FeedbackController::class,'UpdateFeedback']);
Route::delete('/feedback/{id}',[FeedbackController::class,'RemoveFeedback']);

Route::get('/email/verify/{id}/{hash}',[UserController::class,'VerifyEmail'])->middleware(['auth:sanctum','signed:sanctum'])->name('verification.verify');
Route::post('/email/verification-notification',[UserController::class,'ResendVerificationNotification'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
Route::post('/forgot-password',[UserController::class,'SendPasswordReset'])->middleware('guest')->name('password.email');
Route::post('/reset-password',[UserController::class,'UpdatePassword'])->middleware('guest')->name('password.update');
Route::post('/register',[UserController::class,'Register']);
Route::post('/login',[UserController::class,'Login']);
