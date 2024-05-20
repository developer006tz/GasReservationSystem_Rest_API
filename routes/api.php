<?php

use App\Http\Controllers\Api\GasCategotyController;
use App\Http\Controllers\Api\GasPostsController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function ($auth) {
    $auth->post('register', [AuthController::class, 'register']);
    $auth->post('login', [AuthController::class, 'login']);
    $auth->get('user', [AuthController::class, 'getAuthUser']);
    $auth->post('update-profile', [AuthController::class,'updateProfile']);
    $auth->post('logout', [AuthController::class,'logout']);
});


Route::group(['prefix' => 'gas-category', 'middleware' => 'auth:sanctum'], function ($gasGategory) {
    $gasGategory->post('add', [GasCategotyController::class, 'addGasCategory']);
    $gasGategory->get('get', [GasCategotyController::class, 'getGasCategories']);
    $gasGategory->get('get/{category_id}', [GasCategotyController::class, 'getSingleGasCategory']);
});


Route::group(['prefix' => 'gas-post', 'middleware' => 'auth:sanctum'], function ($gasPost) {
    $gasPost->post('add', [GasPostsController::class, 'addGasPost']);
    $gasPost->get('get', [GasPostsController::class, 'getGasPosts']);
    $gasPost->get('get/{post_id}', [GasPostsController::class, 'getSingleGasPost']);
    $gasPost->get('supplier/{supplier_id}', [GasPostsController::class, 'getSupplierGasPosts']);
    $gasPost->patch('publish/{post_id}', [GasPostsController::class, 'publishGasPost']);
    $gasPost->patch('unpublish/{post_id}', [GasPostsController::class, 'unPublishGasPost']);
});


Route::group(['prefix' => 'order', 'middleware' => 'auth:sanctum'], function ($order) {
    $order->post('create', [OrderController::class, 'createOrder']);
    $order->get('get-client-orders/{client_id}', [OrderController::class, 'getClientOrders']);
    $order->get('get-supplier-orders/{supplier_id}', [OrderController::class, 'getSupplierOrders']);
    $order->get('get/{order_id}', [OrderController::class, 'getSingleOrder']);
});
