<?php

use App\Http\Controllers\v1\CategoryController;
use App\Http\Controllers\v1\OccasionController;
use App\Http\Controllers\v1\ProductController;
use App\Models\Occasion;
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

Route::apiResource('occasions',OccasionController::class);
Route::get('/occasions/{occasion}/products',[OccasionController::class,'products']);

Route::apiResource('categories',CategoryController::class);
Route::get('/categories/{category}/subcategory',[CategoryController::class,'subcategory']);
Route::get('/categories/{category}/parentcategory',[CategoryController::class,'parentcategory']);
Route::get('/categories/{category}/products',[CategoryController::class,'products']);

Route::apiResource('products',ProductController::class);
