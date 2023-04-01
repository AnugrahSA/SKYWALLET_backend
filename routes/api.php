<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\RelasibookmarkController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1/user')->group(function(){
    Route::get('/',[UserController::class,'getAlluser']);
    Route::get('/{id}',[UserController::class,'getUserbyid']);
    Route::post('/',[UserController::class,'adduser']);
});

Route::prefix('/v1/bookmark')->group(function(){
    Route::get('/{id}',[BookmarkController::class,'getbookmarkbyiduser']);
    Route::get('/data/{id}',[RelasibookmarkController::class,'getisibookmark']);
});
