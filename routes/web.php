<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('roles', RoleController::class)->except('destroy');
Route::post('delete-role', [RoleController::class,'destroy']);

Route::resource('users', UserController::class)->except('destroy');
Route::post('delete-user', [UserController::class,'destroy']);

Route::resource('bookings', BookingController::class)->except('destroy');
Route::post('delete-booking', [BookingController::class,'destroy']);
