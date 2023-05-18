<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\CompanyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('register', [RegisterController::class, 'register'])->name('auth.register');
Route::post('login', [LoginController::class, 'login'])->name('auth.login');
Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
// Route::get('detail', [LoginController::class, 'detail'])->name('auth.detail')->middleware('auth:sanctum');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('companies', CompanyController::class);
});
