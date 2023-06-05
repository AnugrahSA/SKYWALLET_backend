<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\RelasibookmarkController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthApi\Commands as CommandAuthApi;
use App\Http\Controllers\AuthApi\Queries as QueryAuthApi;
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

Route::prefix('/v1/registrasi')->group(function(){
    Route::post('/add',[RegisterController::class,'create']);
});

Route::post('/v1/login', [CommandAuthApi::class, 'login']);
Route::get('/v1/logout', [QueryAuthApi::class, 'logout'])->middleware(['auth:sanctum']);

Route::prefix('/v1/bookmark')->group(function(){
    Route::get('/{id}',[BookmarkController::class,'getbookmarkbyiduser']);
    Route::get('/data/{id}',[RelasibookmarkController::class,'getisibookmark']);
});

Route::prefix('/v1/keuangan')->middleware(['auth:sanctum'])->group(function(){
    Route::post('/add',[KeuanganController::class,'create']);
    Route::get('/count_total',[KeuanganController::class,'count_total']);
    Route::get('/{year}/{type}',[KeuanganController::class,'getTotalKeuanganbyMonth']);
    Route::get('/day/{month}/{year}/{type}',[KeuanganController::class,'getTotalKeuanganbyDay']);
    Route::get('/count_history',[KeuanganController::class,'count_history']);
});

