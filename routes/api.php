<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::get('/validate-token', [AuthController::class, 'validateToken']);
    Route::apiResource('products', ProductController::class);

});


// Atau lebih secure:
Route::middleware('auth:sanctum')->get('/user-with-role', function (Request $request) {
    return response()->json([
        'user' => $request->user(),
        'is_admin' => $request->user()->is_admin,
        'is_super_user' => $request->user()->is_super_user
    ]);
});
