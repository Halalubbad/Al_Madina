<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProductController;
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

// Route::get('/admins',[AdminController::class ,'index']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products',ProductController::class);

Route::post('login' , [LoginController::class ,'login']);
Route::post('logout' , [LoginController::class ,'logout'])->middleware('auth:sanctum');

Route::get('user/tokens' , [LoginController::class , 'tokens'])->middleware('auth:sanctum');
