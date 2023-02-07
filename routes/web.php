<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DealsController;

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
Route::get('/categories', [CategoriesController::class , 'index']);
Route::get('/deals', [DealsController::class , 'index']);
Route::get('/category-products', [CategoriesController::class , 'products']);
Route::get('/deal-products', [DealsController::class , 'products']);
Route::get('/{any}',function () {
    return view('welcome');
})->where('any', '.*');
