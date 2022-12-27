<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PaymentController;

//Auth
Route::post('/login',[LoginController::class , 'login']);
Route::post('/register',[UserController::class , 'register']);

//Items
Route::prefix('item')->group(function (){
    Route::apiResource('',ItemController::class);
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

