<?php

use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Public route */
//failAuthMiddleware
Route::get('failAuthMiddleware', function () {
    return response()->json(['message' => 'Unauthorized'], 401);
})->name('failAuthMiddleware');

//user
Route::get('users/all',[UserController::class,'index']);
Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
//product
Route::get('products',[ProductController::class,'index']);
Route::get('products/{product}',[ProductController::class,'show']);

/* Protected route */
Route::group(['middleware' => ['auth:sanctum']], function () {
    //user
    route::get('users',[UserController::class,'show']);
    Route::get('logout',[UserController::class,'logout']);
    Route::put('users',[UserController::class,'update']);
    Route::delete('users',[UserController::class,'destroy']);
    //product
    Route::post('products',[ProductController::class,'store']);
    Route::put('products/{product}',[ProductController::class,'update']);
    Route::delete('products/{product}',[ProductController::class,'destroy']);
    //Order
    Route::get('carts', [OrderController::class, 'showCart']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}', [OrderController::class, 'show']);
    Route::post('carts/{product}', [OrderController::class, 'store']);
    Route::put('carts/validate', [OrderController::class, 'validateCart']);
    Route::delete('carts/{product}', [OrderController::class, 'remove']);
    Route::delete('orders/{order}', [OrderController::class, 'destroy']);
});


