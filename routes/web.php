<?php

use Illuminate\Support\Facades\Route;

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/list', [\App\Http\Controllers\TestController::class, 'list']);
Route::get('/never', [\App\Http\Controllers\TestController::class, 'never']);
Route::get('/fill', [\App\Http\Controllers\TestController::class, 'fill']);
Route::get('/orders', [\App\Http\Controllers\TestController::class, 'orders']);

Route::get('/order/{order}', [\App\Http\Controllers\TestController::class, 'edit']);

