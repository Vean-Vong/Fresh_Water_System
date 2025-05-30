<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Get the authenticated user (Protected route)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication routes (Public: No authentication needed)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']); // Public registration route
    Route::post('/login', [AuthController::class, 'login']);       // Public login route

});
// Route::apiResource('/users', AuthController::class);
// Customer routes (Protected: Requires authentication)
Route::apiResource('customers', CustomerController::class);
// Store a newly created customer
// Route::post('/customers', [CustomerController::class, 'store']);
// // Fetch all customers
// Route::get('/customers', [CustomerController::class, 'index']);
// // Fetch a single customer by ID
// Route::get('/customers/{id}', [CustomerController::class, 'show']);
// // Update a customer
// Route::put('/customers/{id}', [CustomerController::class, 'update']);
// // Delete a customer
// Route::delete('/customers/{id}', [CustomerController::class, 'destroy']);

/// Employee route
Route::apiResource('employees', EmployeeController::class);
/// Product route
Route::apiResource('products', ProductController::class);
/// Sale Route
Route::apiResource('sales', SaleController::class);