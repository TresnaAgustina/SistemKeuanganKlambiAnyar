<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Master\Jaritan;

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

// === *** TESTING BACKEND *** === //

// *** Auth Routes *** //
Route::prefix('/auth')->group(function () {
    Route::post('/login', Auth\LoginController::class)->name('login');
    Route::post('/register', Auth\RegisterController::class)->name('register');
    // --Logout
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', Auth\LogoutController::class)->name('logout');
    });
});

// *** Master Jaritan Routes *** //
Route::prefix('/jaritan')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // --View
        Route::get('/all', Jaritan\ViewMasterJaritanController::class)->name('jaritan.all');
        // --Create
        Route::post('/create', Jaritan\CreateMasterJaritanController::class)->name('jaritan.create');
        // --Update
        Route::put('/update/{id}', Jaritan\UpdateMasterJaritanController::class)->name('jaritan.update');
        // --Delete
        Route::delete('/delete/{id}', Jaritan\DeleteMasterJaritanController::class)->name('jaritan.delete');
    });
});


// *** View Routes *** //
// Route::middleware('auth:sanctum')->group(function () {
//     // --Dashboard
//     Route::get('/', function () {
//         return view('welcome');
//     })->name('dashboard');
// });
