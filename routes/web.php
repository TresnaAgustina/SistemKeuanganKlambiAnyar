<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

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

// *** Auth Routes *** //
Route::prefix('/auth')->group(function () {
    Route::post('/login', [LoginController::class])->name('login');
    Route::post('/register', [RegisterController::class])->name('register');
    // --Logout
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [LogoutController::class])->name('logout');
    });
});

// *** View Routes *** //
Route::middleware('auth:sanctum')->group(function () {
    // --Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});