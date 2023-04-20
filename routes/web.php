<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [HomeController::class, 'index'])->name('products.index');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('roles', RoleController::class)->except('destroy');
Route::post('delete-role', [RoleController::class,'destroy']);

Route::resource('users', UserController::class)->except('destroy');
Route::post('delete-user', [UserController::class,'destroy']);



Route::post('ajax-category', [HomeController::class,'ajaxCategory'])->name('ajaxCategory');
Route::post('ajax-product', [HomeController::class,'ajaxProduct'])->name('ajaxProduct');
