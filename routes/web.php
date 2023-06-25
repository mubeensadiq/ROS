<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DealsController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\AreasController;
use App\Http\Controllers\BranchesController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\BannersController;

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
Route::get('/banners', [BannersController::class , 'index']);
Route::get('/categories', [CategoriesController::class , 'index']);
Route::get('/cities-has-areas', [CitiesController::class , 'getCitiesHasAreas']);
Route::get('/areas-by-city', [AreasController::class , 'getAreasByCity']);
Route::get('/branches-by-city', [BranchesController::class , 'getBranchesByCity']);
Route::get('/discount/{id?}', [DiscountsController::class , 'getDiscountDetails']);
Route::get('/category-products', [CategoriesController::class , 'products']);
Route::get('/order-details/{id}', [OrdersController::class , 'getOrderDetails']);
Route::get('/{any}',function () {
    return view('welcome');
})->where('any', '.*');
