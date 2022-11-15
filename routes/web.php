<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
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
Route::get('/category', function () {
    return view('category');
});

Route::get('/billing', function () {
    return view('billing');
});

Route::get('/size', function () {
    return view('size');
});
Route::get('/items', function () {
    return view('items');
});

Route::get('dashboard', [DashboardController::class, 'index']);