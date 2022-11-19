<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SizeColorController;
// use App\Http\Controllers\ColorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductController;

use App\MyApp;
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

Route::get('/', function () {
    return view('/login');
});


Route::get('/login', [AuthController::class, 'index']);
Route::post('/login-auth', [AuthController::class, 'loginAuth']);

//admin
Route::group(['middleware'=>'admin_auth'], function(){

    Route::fallback(function () {
        return view('404');
    });

    Route::get('admin/dashboard', [DashboardController::class, 'index']);
    Route::get('admin/billing', [BillingController::class, 'index']);

    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/admin','index');
        Route::post('admin/save-admin', 'saveAdmin');
        Route::get('admin/edit-admin/{admin_id}', 'editAdmin');
        Route::post('admin/update-admin/{admin_id}', 'updateAdmin');
        Route::get('admin/delete-admin/{admin_id}', 'deleteAdmin');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('admin/user','index');
        Route::post('admin/save-user', 'saveUser');
        Route::get('admin/edit-user/{user_id}', 'editUser');
        Route::post('admin/update-user/{user_id}', 'updateUser');
        Route::get('admin/delete-user/{user_id}', 'deleteUser');
    });
    
    Route::controller(CategoryController::class)->group(function () {
        Route::get('admin/category', 'index');
        Route::post('admin/save-category', 'saveCategory');
        Route::get('admin/edit-category/{category_id}', 'editCategory');
        Route::post('admin/update-category/{category_id}', 'updateCategory');
        Route::get('admin/delete-category/{category_id}', 'deleteCategory');
        

        // Route::post('/orders', 'store');
    });

    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('admin/sub-category', 'index');
        Route::post('admin/save-sub-category', 'saveSubCategory');
        Route::get('admin/edit-sub-category/{sub_category_id}', 'editSubCategory');
        Route::post('admin/update-sub-category/{sub_category_id}', 'updateSubCategory');
        Route::get('admin/delete-sub-category/{sub_category_id}', 'deleteSubCategory');

        Route::get('admin/get-sub-category-by-category/{category_id}', 'getSubCategoryByCategory');
        
    });

    Route::controller(SizeColorController::class)->group(function () {
        Route::get('admin/size-color', 'index');
        //size
        Route::post('admin/save-size', 'saveSize');
        Route::get('admin/edit-size/{size_id}', 'editSize');
        Route::post('admin/update-size/{size_id}', 'updateSize'); 
        Route::get('admin/delete-size/{size_id}', 'deleteSize');

        //color
        Route::post('admin/save-color', 'saveColor');
        Route::get('admin/edit-color/{color_id}', 'editColor');
        Route::post('admin/update-color/{color_id}', 'updateColor'); 
        Route::get('admin/delete-color/{color_id}', 'deleteColor');

    });

    // Route::controller(ColorController::class)->group(function () {
    //     Route::get('admin/color', 'index');
    //     Route::post('admin/save-color', 'saveColor');
    // });

    Route::controller(ProductController::class)->group(function () {
        Route::get('admin/product', 'index');
    });
    
    
    Route::get('admin/logout', [AuthController::class, 'logout']);
});

//billing
Route::group(['middleware'=>'billing_auth'], function(){

    Route::fallback(function () {
        return view('404');
    });

    Route::get('billing', [BillingController::class, 'index']);

    Route::controller(CategoryController::class)->group(function () {
        Route::get('category', 'index');
        // Route::post('/orders', 'store');
    });

    Route::controller(SizeController::class)->group(function () {
        Route::get('size', 'index');
        Route::post('save-size', 'saveSize');
    });

    Route::controller(ColorController::class)->group(function () {
        Route::get('color', 'index');
        Route::post('save-color', 'saveColor');
    });


    Route::get('logout', [AuthController::class, 'logout']);
});





// Route::get('/subcategory', function () {
//     return view('subcategory');
// });





