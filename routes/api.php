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
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\RidersController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\SettingsController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
/************** AUTH ROUTES ************/
Route::post('/login' , [LoginController::class, 'authenticate']);
Route::post('/logout' , [LoginController::class, 'logout']);
Route::post('/save-order', [OrdersController::class , 'saveOrder']);
/************** END AUTH ROUTES ************/
Route::group(['middleware' => ['auth:sanctum']], function () {

    /************** REPORTING ROUTES ************/
    Route::group(['prefix' => 'report'] , function(){
        Route::get('/dashboard-stats', [ReportingController::class , 'DashboardStats']);
        Route::get('/get-report', [ReportingController::class , 'getReport']);
    });
    /************** END REPORTING ROUTES ************/

    /************** SETTING ROUTES ************/
    Route::get('/settings', [SettingsController::class , 'index']);
    Route::post('/save-settings', [SettingsController::class , 'saveSettings']);
    /************** END SETTING ROUTES ************/

    /************** PRODUCT ROUTES ************/
    Route::get('/products', [ProductsController::class , 'index']);
    Route::post('/save-product', [ProductsController::class , 'saveProduct']);
    Route::get('/get-product-details/{id}', [ProductsController::class , 'getProductDetails']);
    Route::delete('/delete-product/{id}', [ProductsController::class , 'deleteProduct']);
    /************** END PRODUCT ROUTES ************/

    /************** DISCOUNT ROUTES ************/
    Route::get('/discounts', [DiscountsController::class , 'index']);
    Route::post('/save-discount', [DiscountsController::class , 'saveDiscount']);
    Route::get('/get-discount-details/{id}', [DiscountsController::class , 'getDiscountDetails']);
    Route::delete('/delete-discount/{id}', [DiscountsController::class , 'deleteDiscount']);
    /************** END DISCOUNT ROUTES ************/

    /************** USER ROUTES ************/
    Route::get('/users', [UsersController::class , 'index']);
    Route::post('/save-user', [UsersController::class , 'saveUser']);
    Route::delete('/delete-user/{id}', [UsersController::class , 'deleteUser']);
    Route::get('/get-user-details/{id}', [UsersController::class , 'getUserDetails']);
    /************** END USER ROUTES ************/

    /************** RIDER ROUTES ************/
    Route::get('/riders', [RidersController::class , 'index']);
    Route::post('/save-rider', [RidersController::class , 'saveRider']);
    Route::get('/get-rider-details/{id}', [RidersController::class , 'getRiderDetails']);
    Route::delete('/delete-rider/{id}', [RidersController::class , 'deleteRider']);
    /************** END RIDER ROUTES ************/

    /************** ROLE ROUTES ************/
    Route::get('/roles', [UsersController::class , 'getRoles']);
    Route::post('/save-role', [UsersController::class , 'saveRole']);
    Route::get('/permissions', [UsersController::class , 'getPermissions']);
    Route::get('/get-role-details/{id}', [UsersController::class , 'getRoleDetails']);
    Route::delete('/delete-role/{id}', [UsersController::class , 'deleteRole']);
    /************** END ROLE ROUTES ************/

    /************** CITIES ROUTES ************/
    Route::get('/cities', [CitiesController::class , 'index']);
    Route::get('/cities-has-areas', [CitiesController::class , 'getCitiesHasAreas']);
    Route::post('/save-city', [CitiesController::class , 'saveCity']);
    Route::get('/get-city-details/{id}', [CitiesController::class , 'getCityDetails']);
    Route::delete('/delete-city/{id}', [CitiesController::class , 'deleteCity']);
    /************** END CITIES ROUTES ************/

    /************** CATEGORIES ROUTES ************/
    Route::get('/categories', [CategoriesController::class , 'index']);
    Route::post('/save-category', [CategoriesController::class , 'saveCategory']);
    Route::get('/get-category-details/{id}', [CategoriesController::class , 'getCategoryDetails']);
    Route::delete('/delete-category/{id}', [CategoriesController::class , 'deleteCategory']);
    /************** END CATEGORIES ROUTES ************/



    /************** DEAL ROUTES ************/
    Route::get('/deals', [DealsController::class , 'index']);
    Route::post('/save-deal', [DealsController::class , 'saveDeal']);
    Route::get('/get-deal-details/{id}', [DealsController::class , 'getDealDetails']);
    Route::delete('/delete-deal/{id}', [DealsController::class , 'deleteDeal']);
    /************** END DEAL ROUTES ************/

    /************** AREAS ROUTES ************/
    Route::get('/areas', [AreasController::class , 'index']);
    Route::get('/areas-by-city', [AreasController::class , 'getAreasByCity']);
    Route::post('/save-area', [AreasController::class , 'saveArea']);
    Route::get('/get-area-details/{id}', [AreasController::class , 'getAreaDetails']);
    Route::delete('/delete-area/{id}', [AreasController::class , 'deleteArea']);
    /************** END AREAS ROUTES ************/

    /************** BRANCH ROUTES ************/
    Route::get('/branches', [BranchesController::class , 'index']);
    Route::post('/save-branch', [BranchesController::class , 'saveBranch']);
    Route::get('/get-branch-details/{id}', [BranchesController::class , 'getBranchDetails']);
    Route::delete('/delete-branch/{id}', [BranchesController::class , 'deleteBranch']);
    /************** END BRANCH ROUTES ************/

    /************** ADDON CATEGORIES ROUTES ************/
    Route::get('/addon-categories', [AddonsController::class , 'addonCategories']);
    Route::post('/save-addon-category', [AddonsController::class , 'saveAddonCategory']);
    Route::get('/get-addon-category-details/{id}', [AddonsController::class , 'getAddonCategoryDetails']);
    Route::delete('/delete-addon-category/{id}', [AddonsController::class , 'deleteAddonCategory']);
    /************** END CATEGORIES ROUTES ************/

    /************** ADDON ROUTES ************/
    Route::get('/addons', [AddonsController::class , 'index']);
    Route::post('/save-addon', [AddonsController::class , 'saveAddon']);
    Route::get('/get-addon-details/{id}', [AddonsController::class , 'getAddonDetails']);
    Route::delete('/delete-addon/{id}', [AddonsController::class , 'deleteAddon']);
    /************** END ADDON ROUTES ************/

    /************** ORDER ROUTES ************/
    Route::get('/orders', [OrdersController::class , 'index']);
    Route::get('/order-details/{id}', [OrdersController::class , 'getOrderDetails']);
    Route::post('/update-order', [OrdersController::class , 'updateOrder']);
    Route::get('/checkout', [OrdersController::class , 'checkOut']);
    /************** END ORDER ROUTES ************/

    /************** BANNER ROUTES ************/
    Route::get('/banners', [BannersController::class , 'index']);
    Route::post('/save-banner', [BannersController::class , 'saveBanner']);
    Route::delete('/delete-banner/{id}', [BannersController::class , 'deleteBanner']);
    /************** END BANNER ROUTES ************/

    /************** SINGLE ROUTES ************/
    Route::post('/upload-image', [ImageController::class,'upload']);
    /************** END SINGLE ROUTES ************/
});


