<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;


//Auth
Route::post('/login',[AuthController::class , 'login']);
Route::post('/register',[UserController::class , 'register']);

//Items
Route::prefix('item')->group(function (){
    // Route::apiResource('',ItemController::class);
    Route::get('/' , [ItemController::class , 'index']);
    Route::post('/' , [ItemController::class , 'store']);
    Route::put('/{id}' , [ItemController::class , 'update']);
    Route::delete('/{id}' , [ItemController::class , 'destroy']);
    Route::get('/{id}',[ItemController::class,'show']);
});

//Payments
Route::prefix('payments')->group(function(){
    Route::get('/' , [PaymentController::class , 'index']);
    Route::put('/{id}' , [PaymentController::class , 'update']);
    Route::delete('/{id}' , [PaymentController::class , 'delete']);
    Route::get('/invoice/{id}' , [PaymentController::class , 'getInvoice']);
    Route::get('/user/{id}' , [PaymentController::class , 'getUser']);
    Route::get('/client/{id}' , [PaymentController::class , 'getClient']);
});
Route::post('/payments-delete',[PaymentController::class,'bulkDelete']);

//Orders
Route::prefix('orders')->group(function (){
    Route::get('/' , [OrdersController::class , 'index']);
    Route::post('/' , [OrdersController::class , 'store']);
});


//test routes
Route::get('/item-relation' , [TestController::class , 'item_relation'])->middleware('auth:sanctum');

