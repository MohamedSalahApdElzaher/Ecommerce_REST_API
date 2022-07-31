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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// products
Route::apiResource('/products', \App\Http\Controllers\ProductController::class);

// reviews
Route::group(['prefix' => 'product'], function (){
    Route::apiResource('/{product}/review', \App\Http\Controllers\ReviewController::class);
});

// user registration/login
Route::post('user/register', [\App\Http\Controllers\UserController::class, 'Register']);
Route::post('user/login', [\App\Http\Controllers\UserController::class, 'Login']);

