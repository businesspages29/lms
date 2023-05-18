<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
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

Auth::routes([
    'register' => false,
]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('users', UserController::class)->except('destroy');
    Route::post('delete-user', [UserController::class,'destroy']);

    Route::resource('companies', CompanyController::class)->except('destroy');
    Route::post('delete-company', [CompanyController::class,'destroy']);

    Route::resource('employees', EmployeeController::class)->except('destroy');
    Route::post('delete-employee', [EmployeeController::class,'destroy']);
});
