<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoListController;
use App\Http\Controllers\userController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# user routes
Route::get('user/login',[userController::class,'login']);
Route::post('user/doLogin',[userController::class,'doLogin']);
Route::get('user/logout',[userController::class,'logout']);



Route::get('index/',[todoListController::class,'index']);
Route::get('create/',[todoListController::class,'create']);
Route::post('store/',[todoListController::class,'store']);
Route::get('/delete/{id}',[todoListController::class,'delete']);

