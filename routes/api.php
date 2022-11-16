<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\AdminController;

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

// Route::post('/login-auth', [AuthAPIController::class, 'loginAuth']);
Route::post('/admin-login', [AuthAPIController::class, 'adminLogin']);
Route::post('/user-login', [AuthAPIController::class, 'userLogin']);


Route::get('/admin', [AdminController::class, 'index']);
