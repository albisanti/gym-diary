<?php

use App\Http\Controllers\UserCustomerController;
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

Route::middleware('auth:sanctum')->group(function(){
    //Category related routes\
    Route::prefix('/category')->group(function(){
        Route::get('/',[CategoryController::class,'getAllCategories']);
        Route::get('/{id}',[CategoryController::class,'getCategory'])->whereNumber('id');
        Route::put('/',[CategoryController::class,'createCategory']);
        Route::patch('/{id}',[CategoryController::class,'updateCategory'])->whereNumber('id');
        Route::delete('/{id}',[CategoryController::class,'deleteCategory'])->whereNumber('id');
    });

    //Macro related routes
    Route::prefix('/macro')->group(function(){
        Route::get('/',[MacroController::class,'getAllMacros']);
        Route::get('/{id}',[MacroController::class,'getMacro'])->whereNumber('id');
        Route::put('/',[MacroController::class,'createMacro']);
        Route::patch('/{id}',[MacroController::class,'updateMacro'])->whereNumber('id');
        Route::delete('/{id}',[MacroController::class,'deleteMacro'])->whereNumber('id');
    });

    //Equipment related routes
    Route::prefix('/equipment')->group(function(){
        Route::get('/',[EquipmentController::class,'getAllEquipments']);
        Route::get('/{id}',[EquipmentController::class,'getEquipment'])->whereNumber('id');
        Route::put('/',[EquipmentController::class,'createEquipment']);
        Route::patch('/{id}',[EquipmentController::class,'updateEquipment'])->whereNumber('id');
        Route::delete('/{id}',[EquipmentController::class,'deleteEquipment'])->whereNumber('id');
    });

    //Exercise related routes
    Route::prefix('/exercise')->group(function(){
        Route::get('/',[ExerciseController::class,'getAllExercises']);
        Route::get('/{id}',[ExerciseController::class,'getExercise'])->whereNumber('id');
        Route::put('/',[ExerciseController::class,'createExercise']);
        Route::patch('/{id}',[ExerciseController::class,'updateExercise'])->whereNumber('id');
        Route::delete('/{id}',[ExerciseController::class,'deleteExercise'])->whereNumber('id');
    });

//Exercise related routes
    Route::prefix('/workout')->group(function(){
        Route::get('/',[WorkoutController::class,'getAllWorkouts']);
        Route::get('/{id}',[WorkoutController::class,'getWorkout'])->whereNumber('id');
        Route::put('/',[WorkoutController::class,'createWorkout']);
        Route::patch('/{id}',[WorkoutController::class,'updateWorkout'])->whereNumber('id');
        Route::delete('/{id}',[WorkoutController::class,'deleteWorkout'])->whereNumber('id');
    });

    //Workouts' exercises related routes
    Route::prefix('/workout/exercises')->group(function(){
        Route::get('/{id}',[WorkoutExerciseController::class,'GetWorkoutsExercises'])->whereNumber('id');
        Route::put('/',[WorkoutExerciseController::class,'AddNewExercise']);
        Route::patch('/',[WorkoutExerciseController::class,'UpdateWorkoutsExercises']);
        Route::delete('/',[WorkoutExerciseController::class,'DeleteWorkoutsExercises']);
    });

    //Feedback releted routes
    Route::prefix('/feedback')->group(function(){
        Route::get('/{workoutId}',[FeedbackController::class,'GetFeedbackFromWorkoutId'])->whereNumber('workoutId');
        Route::put('/',[FeedbackController::class,'AddNewFeedback']);
        Route::patch('/{id}',[FeedbackController::class,'UpdateFeedback']);
        Route::delete('/{id}',[FeedbackController::class,'RemoveFeedback']);
    });
});

//Customers related routes
Route::prefix('/customer')->group(function () {
    Route::put('/add',[UserCustomerController::class,'AddNewCustomer'])->middleware(['auth:sanctum']);
    Route::patch('/{accepted}',[UserCustomerController::class,'AcceptOrRefuseInvitation'])->where('accepted','accepted|refused');
    Route::delete('/remove',[UserCustomerController::class,'DeleteCustomer'])->whereNumber('id')->middleware(['auth:sanctum']);
    Route::patch('/finalize-user',[UserCustomerController::class,'FinalizeUserCreation']);
    Route::get('/',[UserCustomerController::class,'GetCustomers'])->middleware(['auth:sanctum']);
});
//User related routes
Route::get('/email/verify/{id}/{hash}',[UserController::class,'VerifyEmail'])->middleware(['auth:sanctum','signed:sanctum'])->name('verification.verify');
Route::post('/email/verification-notification',[UserController::class,'ResendVerificationNotification'])->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
Route::post('/forgot-password',[UserController::class,'SendPasswordReset'])->middleware('guest')->name('password.email');
Route::post('/reset-password',[UserController::class,'UpdatePassword'])->middleware('guest')->name('password.update');
Route::post('/register',[UserController::class,'Register']);
Route::post('/login',[UserController::class,'Login']);
