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
use App\Http\Controllers\AddonsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ImageController;

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
Route::group(['middleware' => ['auth:api']], function () {



});
Route::post('/login' , [LoginController::class, 'authenticate']);
Route::post('/logout' , [LoginController::class, 'logout']);
Route::get('/roles', [UsersController::class , 'getRoles']);
Route::get('/users', [UsersController::class , 'index']);
Route::post('/save-user', [UsersController::class , 'saveUser']);
Route::delete('/delete-user/{id}', [UsersController::class , 'deleteUser']);
Route::get('/get-user-details/{id}', [UsersController::class , 'getUserDetails']);
Route::get('/cities', [CitiesController::class , 'index']);
Route::get('/cities-has-areas', [CitiesController::class , 'getCitiesHasAreas']);
Route::get('/areas', [AreasController::class , 'index']);
Route::post('/save-area', [AreasController::class , 'saveArea']);
Route::get('/get-area-details/{id}', [AreasController::class , 'getAreaDetails']);
Route::delete('/delete-area/{id}', [AreasController::class , 'deleteArea']);
Route::get('/areas-by-city', [AreasController::class , 'getAreasByCity']);
Route::get('/categories', [CategoriesController::class , 'index']);
Route::post('/save-category', [CategoriesController::class , 'saveCategory']);
Route::get('/get-category-details/{id}', [CategoriesController::class , 'getCategoryDetails']);
Route::delete('/delete-category/{id}', [CategoriesController::class , 'deleteCategory']);
Route::get('/deals', [DealsController::class , 'index']);
Route::get('/branches', [BranchesController::class , 'index']);
Route::post('/save-branch', [BranchesController::class , 'saveBranch']);
Route::get('/get-branch-details/{id}', [BranchesController::class , 'getBranchDetails']);
Route::delete('/delete-branch/{id}', [BranchesController::class , 'deleteBranch']);
Route::get('/addons', [AddonsController::class , 'index']);
Route::post('/save-addon', [AddonsController::class , 'saveAddon']);
Route::get('/get-addon-details/{id}', [AddonsController::class , 'getAddonDetails']);
Route::delete('/delete-addon/{id}', [AddonsController::class , 'deleteAddon']);
Route::get('/products', [ProductsController::class , 'index']);
Route::post('/save-product', [ProductsController::class , 'saveProduct']);
Route::get('/get-product-details/{id}', [ProductsController::class , 'getProductDetails']);
Route::delete('/delete-product/{id}', [ProductsController::class , 'deleteProduct']);
Route::post('/upload-image', [ImageController::class,'upload']);

//Route::middleware(['auth'])->group(function () {
//    Route::get('/users', [UsersController::class , 'index']);
//});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
