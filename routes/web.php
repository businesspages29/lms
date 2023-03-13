<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SurveyController;
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

Route::resource('questions/{id}/answers', AnswerController::class)->except('destroy');
Route::post('delete-answer', [AnswerController::class,'destroy']);

Route::resource('questions', QuestionController::class)->except('destroy');
Route::post('delete-question', [QuestionController::class,'destroy']);

Route::controller(SurveyController::class)->group(function () {
    Route::get('survey', 'form')->name('survey.form');
    Route::post('survey', 'store')->name('survey.store');
});
