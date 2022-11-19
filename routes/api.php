<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\API\MasterAPIController;

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

Route::get('/users', [UserAPIController::class, 'getUsers']);

Route::controller(MasterAPIController::class)->group(function () {
    Route::get('get-category', 'getCategory');
    Route::get('get-sub-category/{category_id}', 'getSubCategory');
});

Route::get('/admin', [AdminController::class, 'index']);
