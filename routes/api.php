<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Master\Jaritan;
use App\Http\Controllers\Master\Pemasukan;
use App\Http\Controllers\Master\Pengeluaran;

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
        Route::post('/update/{id}', Jaritan\UpdateMasterJaritanController::class)->name('jaritan.update');
        // --Delete
        Route::delete('/delete/{id}', Jaritan\DeleteMasterJaritanController::class)->name('jaritan.delete');
    });
});


// *** Master Pemasukan Routes *** //
Route::prefix('/pemasukan')->group(function () {
    // --view
    Route::get('/all', Pemasukan\ViewMasterPemasukanController::class)->name('pemasukan.all');
    // --create
    Route::post('/create', Pemasukan\CreateMasterPemasukanController::class)->name('pemasukan.create');
    // --update
    Route::post('/update/{id}', Pemasukan\UpdateMasterPemasukanController::class)->name('pemasukan.update');
    // --delete
    Route::delete('/delete/{id}', Pemasukan\DeleteMasterPemasukanController::class)->name('pemasukan.delete');
});

// *** Master Pengeluaran Routes *** //
Route::prefix('/pengeluaran')->group(function () {
    // --view
    Route::get('/all', Pengeluaran\ViewMasterPengeluaranController::class)->name('pengeluaran.all');
    // --create
    Route::post('/create', Pengeluaran\CreateMasterPengeluaranController::class)->name('pengeluaran.create');
    // --update
    Route::post('/update/{id}', Pengeluaran\UpdateMasterPengeluaranController::class)->name('pengeluaran.update');
    // --delete
    Route::delete('/delete/{id}', Pengeluaran\DeleteMasterPengeluaranController::class)->name('pengeluaran.delete');
});




// *** View Routes *** //
// Route::middleware('auth:sanctum')->group(function () {
//     // --Dashboard
//     Route::get('/', function () {
//         return view('welcome');
//     })->name('dashboard');
// });
