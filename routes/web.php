<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\UserController;
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

    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/admin', 'index');
        Route::post('admin/save-admin', 'saveAdmin');
        Route::get('admin/edit-admin/{admin_id}', 'editAdmin');
        Route::post('admin/update-admin/{admin_id}', 'updateAdmin');
        Route::delete('admin/delete-admin/{admin_id}', 'deleteAdmin');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('admin/user', 'index');
        Route::post('admin/save-user', 'saveUser');
    });
    
    Route::controller(CategoryController::class)->group(function () {
        Route::get('admin/category', 'index');
        Route::post('admin/save-category', 'saveCategory');

        // Route::post('/orders', 'store');
    });

    Route::controller(SizeController::class)->group(function () {
        Route::get('admin/size', 'index');
        Route::post('admin/save-size', 'saveSize');
    });

    Route::controller(ColorController::class)->group(function () {
        Route::get('admin/color', 'index');
        Route::post('admin/save-color', 'saveColor');
    });
    
    
    Route::get('admin/logout', [AuthController::class, 'logout']);
});

//billing
Route::group(['middleware'=>'billing_auth'], function(){

    Route::fallback(function () {
        return view('404');
    });

    Route::get('billing', [BillingController::class, 'index']);


    Route::get('logout', [AuthController::class, 'logout']);
});



Route::get('/items', function () {
    return view('items');
});





