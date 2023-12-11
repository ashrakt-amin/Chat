<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\UserLoginController;
use App\Http\Controllers\Api\Auth\AdminLoginController;



Route::prefix("admin")->group(function () {
    Route::controller(AdminLoginController::class)->group(function () {
        Route::post('/login', 'login');
    });
});

Route::prefix("user")->group(function () {
    Route::controller(UserLoginController::class)->group(function () {
        Route::post('/login', 'login');
    });
});

Route::prefix("register")->group(function () {
    Route::controller(RegisterController::class)->group(function () {
        Route::post('/user', 'userRegister');
        Route::post('/admin', 'adminRegister');

    });
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function () {
    return "user";
});
});

Route::middleware('auth:admin-api')->group(function () {
    Route::get('/admin', function () {
    return "admin";
});
});
