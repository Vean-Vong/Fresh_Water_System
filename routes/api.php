<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider and assigned the "api"
| middleware group. Use "auth:sanctum" for secure routes.
|
*/

// Get the authenticated user (Protected route)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication routes (Public: No authentication needed)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']); // Public registration route
    Route::post('/login', [AuthController::class, 'login']);       // Public login route
});

// Customer routes (Protected: Requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store'); // Only accessible if logged in
});
