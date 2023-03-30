<?php

use App\Http\Controllers\EmployeeLeaveMasterController;
use App\Http\Controllers\LeaveMasterController;
use App\Http\Controllers\NonWorkingDayController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('roles', RoleController::class)->except('destroy');
Route::post('delete-role', [RoleController::class,'destroy']);

Route::resource('users', UserController::class)->except('destroy');
Route::post('delete-user', [UserController::class,'destroy']);

Route::resource('users/{id}/leave', EmployeeLeaveMasterController::class)->except(['destroy','show']);


Route::resource('leave-master', LeaveMasterController::class)->except(['destroy','show']);
Route::post('delete-leave-master', [LeaveMasterController::class,'destroy']);

Route::resource('non-working-day', NonWorkingDayController::class)->except(['destroy','show']);
Route::post('delete-non-working-day', [NonWorkingDayController::class,'destroy']);
