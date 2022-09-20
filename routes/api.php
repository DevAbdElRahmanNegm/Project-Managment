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


Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'userlogin']);


    Route::middleware('auth:api')->group(

    function () {
    Route::get('/profile', [\App\Http\Controllers\API\AuthController::class, 'profile']);

    Route::get('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);

    Route::get('/tasks/all',[\App\Http\Controllers\API\EmployeeController::class,'ShowAllTasks']);

    Route::post('/tasks/submit/{id}',[\App\Http\Controllers\API\EmployeeController::class,'SubmitTask']);

    //supervisor Route
    Route::middleware('admin')->group(function () {
        //Project Routes
        Route::get('/projects', [\App\Http\Controllers\API\ProjectController::class, 'index']);
        Route::post('/projects/store', [\App\Http\Controllers\API\ProjectController::class, 'store']);
        Route::get('/projects/{id}', [\App\Http\Controllers\API\ProjectController::class, 'show']);
        Route::post('/projects/update/{id}', [\App\Http\Controllers\API\ProjectController::class, 'update']);
        Route::get('/projects/delete/{id}', [\App\Http\Controllers\API\ProjectController::class, 'delete']);

        //Task Route
        Route::get('/tasks', [\App\Http\Controllers\API\TaskController::class, 'index']);
        Route::post('/tasks/store', [\App\Http\Controllers\API\TaskController::class, 'store']);
        Route::get('/tasks/{id}', [\App\Http\Controllers\API\TaskController::class, 'show']);
        Route::post('/tasks/update/{id}', [\App\Http\Controllers\API\TaskController::class, 'update']);
        Route::get('/tasks/delete/{id}', [\App\Http\Controllers\API\TaskController::class, 'delete']);

    });
    //end


});
