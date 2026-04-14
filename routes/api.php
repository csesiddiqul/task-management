<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/user', [UserController::class, 'user']);
    Route::get('/users', [UserController::class, 'index']);

    Route::apiResource('tasks', TaskController::class);
    Route::get('/my-tasks', [TaskController::class, 'myTasks']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
