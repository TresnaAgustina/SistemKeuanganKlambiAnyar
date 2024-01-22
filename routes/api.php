<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Master\Jaritan;
use App\Http\Controllers\Master\Pemasukan;
use App\Http\Controllers\Master\Pengeluaran;
use App\Http\Controllers\Pemasukan\GetAllPemasukanController;
use App\Http\Controllers\Pemasukan\CreatePemasukanController;
use App\Http\Controllers\Pemasukan\UpdatePemasukanController;
use App\Http\Controllers\Pemasukan\DeletePemasukanController;
use App\Http\Controllers\Pemasukan\GetDetailPemasukanController;
use App\Http\Controllers\Pemasukan\SearchPemasukanController;

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
Route::prefix('/mstr/jaritan')->group(function () {
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
Route::prefix('/mstr/pemasukan')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // --view
        Route::get('/all', Pemasukan\ViewMasterPemasukanController::class)->name('pemasukan.all');
        // --create
        Route::post('/create', Pemasukan\CreateMasterPemasukanController::class)->name('pemasukan.create');
        // --update
        Route::post('/update/{id}', Pemasukan\UpdateMasterPemasukanController::class)->name('pemasukan.update');
        // --delete
        Route::delete('/delete/{id}', Pemasukan\DeleteMasterPemasukanController::class)->name('pemasukan.delete');
    });
});

// *** Master Pengeluaran Routes *** //
Route::prefix('/mstr/pengeluaran')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // --view
        Route::get('/all', Pengeluaran\ViewMasterPengeluaranController::class)->name('pengeluaran.all');
        // --create
        Route::post('/create', Pengeluaran\CreateMasterPengeluaranController::class)->name('pengeluaran.create');
        // --update
        Route::post('/update/{id}', Pengeluaran\UpdateMasterPengeluaranController::class)->name('pengeluaran.update');
        // --delete
        Route::delete('/delete/{id}', Pengeluaran\DeleteMasterPengeluaranController::class)->name('pengeluaran.delete');
    });
});

// *** Pemasukan Routes *** //
Route::prefix('/pemasukan')->group(function () {
        // --view
        Route::get('/all', GetAllPemasukanController::class)->name('pemasukan.all');
        // --get by id
        Route::get('/detail/{id}', GetDetailPemasukanController::class)->name('pemasukan.get');
        // --search
        Route::get('/search', SearchPemasukanController::class)->name('pemasukan.search');
        // --create
        Route::post('/create', CreatePemasukanController::class)->name('pemasukan.create');
        // --update
        Route::post('/update/{id}', UpdatePemasukanController::class)->name('pemasukan.update');
        // --delete
        Route::delete('/delete/{id}', DeletePemasukanController::class)->name('pemasukan.delete');
});




// *** View Routes *** //
// Route::middleware('auth:sanctum')->group(function () {
//     // --Dashboard
//     Route::get('/', function () {
//         return view('welcome');
//     })->name('dashboard');
// });
