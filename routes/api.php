<?php

use App\Http\Controllers\AuditController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MutationController;
use App\Http\Controllers\MutationProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Mutation;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
	Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
	Route::post('/login', [AuthController::class, 'login']);
	Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
	Route::put('/update-profile', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');
	Route::put('/change-password', [AuthController::class, 'changePassword'])->middleware('auth:sanctum');
});

Route::prefix('mutations')->group(function () {
	Route::get('/products/{productId}', [MutationController::class, 'mutationProduct']);
	Route::get('/users/{userId}', [MutationController::class, 'mutationUser']);
});

Route::prefix('audits')->group(function () {
	Route::get('/products/{productId}', [AuditController::class, 'auditProduct']);
	Route::get('/categories/{categoryId}', [AuditController::class, 'auditCategory']);
});

Route::prefix('products')->group(function () {
	Route::get('/trashed', [ProductController::class, 'trashed']);
	Route::put('/restore/{id}', [ProductController::class, 'restore']);
});
Route::prefix('users')->group(function () {
	Route::get('/trashed', [UserController::class, 'trashed']);
	Route::put('/restore/{id}', [UserController::class, 'restore']);
});

Route::prefix('options')->group(function () {
	Route::get('/units', function () {
		return response()->json(['options' => Product::UNIT_OPTIONS]);
	});
	Route::get('/types', function () {
		return response()->json(['options' => Mutation::TYPES_OPTIONS]);
	});
});

Route::apiResources([
	'products' => ProductController::class,
	'categories' => CategoryController::class,
	'users' => UserController::class,
	'mutations' => MutationController::class,
]);
