<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\todoListController;
use App\Http\Controllers\userController;
use App\Models\todoList;
use phpDocumentor\Reflection\Types\Resource_;

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
Route::get('user/register',[userController::class,'register']);
Route::post('user/register',[userController::class,'doRegister']);

Route::middleware(['checkauth'])->group(function(){
    Route::get('user/{id}',[userController::class,'show']);
    Route::put('user/{id}',[userController::class,'update']);
    });
#todolist routes
Route::resource('todolist',todoListController::class)->middleware(['checkauth']);
