<?php

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
Route::post('/product',[ProductController::class,'store']);
Route::get('/product',[ProductController::class,'showAll']);
Route::get('/product/{id}',[ProductController::class,'showById']);
Route::get('/product/name',[ProductController::class,'showByName']);
Route::get('/product/type',[ProductController::class,'showByType']);
Route::put('/product',[ProductController::class,'UpdateProduct']);
Route::delete('/product/{id}',[ProductController::class, 'deleteProduct']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
