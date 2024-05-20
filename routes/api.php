<?php

use App\Http\Controllers\Api\GasPostsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Models\GasCategory;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function ($auth) {
    $auth->post('register', [AuthController::class, 'register']);
    $auth->post('login', [AuthController::class, 'login']);
    $auth->get('user', [AuthController::class, 'getAuthUser']);
});

Route::apiResource('gas-categories', GasCategory::class)->middleware('auth:sanctum')->only(['index', 'store', 'update']);
Route::apiResource('gas-posts', GasPostsController::class)->middleware('auth:sanctum')->only(['index', 'store', 'show', 'update', 'destroy']);
Route::apiResource('orders', GasPostsController::class)->only(['index', 'store', 'show', 'update', 'destroy']);

Route::get('supplier-orders/{supplier_id}', [OrderController::class, 'getSupplierOrders']);
