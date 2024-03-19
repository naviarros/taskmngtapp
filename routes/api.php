<?php

use App\Http\Controllers\Tasks\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Authentication\AuthController;

Route::prefix('auth')->group(function(){
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('v1')->group(function(){
        Route::prefix('users')->group(function(){
            Route::get('/', [UserController::class, 'index']);
            Route::get('/show', [UserController::class, 'show']);
            Route::post('/create', [UserController::class,'store']);
            Route::put('/update', [UserController::class, 'update']);
            Route::delete('/delete', [UserController::class, 'delete']);
        });

        Route::prefix('tasks')->group(function(){
            Route::get('/', [TasksController::class, 'index']);
            Route::get('/show', [TasksController::class, 'show']);
            Route::post('/create', [TasksController::class,'store']);
            Route::put('/update', [TasksController::class, 'update']);
            Route::delete('/delete', [TasksController::class, 'destroy']);
        });
    });
});

