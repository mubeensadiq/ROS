<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DealsController;
use App\Http\Controllers\BranchesController;

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
Route::post('/login' , [LoginController::class, 'authenticate']);
Route::get('/users', [UsersController::class , 'index']);
Route::get('/cities', [CitiesController::class , 'index']);
Route::get('/areas', [AreasController::class , 'index']);
Route::get('/categories', [CategoriesController::class , 'index']);
Route::get('/deals', [DealsController::class , 'index']);
Route::get('/branches', [BranchesController::class , 'index']);
//Route::middleware(['auth'])->group(function () {
//    Route::get('/users', [UsersController::class , 'index']);
//});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
