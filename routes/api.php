<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\API\MasterAPIController;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\CustomerAPIController;

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

Route::get('/admin', [AuthAPIController::class, 'getAdmin']);
// Route::post('/login-auth', [AuthAPIController::class, 'loginAuth']);
Route::post('/admin-login', [AuthAPIController::class, 'adminLogin']);
Route::post('/user-login', [AuthAPIController::class, 'userLogin']);

Route::controller(UserAPIController::class)->group(function () {
    Route::get('users', 'getUsers');
    Route::get('user/{user_id}', 'getUser');
});

Route::controller(MasterAPIController::class)->group(function () {
    Route::get('get-category', 'getCategory');
    Route::get('get-sub-category/{category_id}', 'getSubCategory');
    Route::get('get-color', 'getColor');
    Route::get('get-size', 'getSize');
    Route::get('get-brand', 'getBrand');
});

Route::controller(ProductAPIController::class)->group(function () {
    Route::get('available-stock', 'availableStock');
    Route::get('sales-invoice', 'salesInvoice');
    // Route::get('filter-available-stock/{category_id?}/{sub_category_id?}/{size?}/{color?}', 'filterAvailableStock');
    Route::post('filter-available-stock', 'filterAvailableStock');
    Route::post('filter-sales-invoice', 'filterSalesInvoice');
    Route::get('show-product/{category_id}/{sub_category_id?}/{brand_id?}/{style_no_id?}/{color?}','showProduct');
});

Route::controller(CustomerAPIController::class)->group(function () {
    Route::get('customer', 'getCustomer');
    Route::get('customer-bill/{customer_id}', 'getCustomerBill');
    Route::get('today-sales', 'todaySales');
});

Route::get('/admin', [AdminController::class, 'index']);
