<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/all-categories', [CategoryController::class, 'getCategories']);
Route::get('/products/all', [ProductController::class, 'getProducts']);
Route::get('/products/{id}/single', [ProductController::class, 'singleProduct']);

Route::get('/orders', [OrderController::class, 'index']);

Route::middleware(['auth.jwt'])->group(function () {
    Route::post('/category/create', [CategoryController::class, 'createCategory']);
    Route::post('/category/{id}/update', [CategoryController::class, 'updateCategory']);
    Route::post('/product/create', [ProductController::class, 'createProduct']);
    Route::post('/product/{id}/update', [ProductController::class, 'updateProduct']);

});
