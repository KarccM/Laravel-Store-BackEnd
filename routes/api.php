<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
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

Route::post('/login',[LoginController::class , 'login']);
Route::post('/register',[UserController::class , 'register']);

Route::prefix('item')->group(function (){
    Route::get('/' , [ItemController::class , 'index']);
    Route::post('/' , [ItemController::class , 'store']);
    Route::get('/{item}' , [ItemController::class , 'show']);
    Route::put('/{item}' , [ItemController::class , 'update']);
    Route::delete('/{item}' , [ItemController::class , 'destroy']);
    Route::get('/relation' , [ItemController::class , 'relation']);
});
