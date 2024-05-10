<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'],function ($auth){
    $auth->post('register', [AuthController::class, 'register']);
    $auth->post('login', [AuthController::class, 'login']);
    $auth->get('user', [AuthController::class, 'getAuthUser']);
});
