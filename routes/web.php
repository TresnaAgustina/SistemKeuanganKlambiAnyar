<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ViewLoginController;
use App\Http\Controllers\DataTable\DataTableController;
use App\Http\Controllers\Pemasukan\CreatePemasukanController;
use App\Http\Controllers\Pemasukan\DeletePemasukanController;
use App\Http\Controllers\Pemasukan\GetAllPemasukanController;
use App\Http\Controllers\Pemasukan\SearchPemasukanController;
use App\Http\Controllers\Pemasukan\UpdatePemasukanController;
use App\Http\Controllers\Pemasukan\GetDetailPemasukanController;
use App\Http\Controllers\Pengeluaran\CreatePengeluaranController;
use App\Http\Controllers\Pengeluaran\DeletePengeluaranController;
use App\Http\Controllers\Pengeluaran\GetAllPengeluaranController;
use App\Http\Controllers\Pengeluaran\SearchPengeluaranController;
use App\Http\Controllers\Pengeluaran\UpdatePengeluaranController;
use App\Http\Controllers\Pengeluaran\GetDetailPengeluaranController;
use App\Http\Controllers\Master\Jaritan\ViewMasterJaritanController;
use App\Http\Controllers\Master\Jaritan\CreateMasterJaritanController;
use App\Http\Controllers\Master\Jaritan\DeleteMasterJaritanController;
use App\Http\Controllers\Master\Jaritan\UpdateMasterJaritanController;
use App\Http\Controllers\Master\Pemasukan\ViewMasterPemasukanController;
use App\Http\Controllers\Master\Pemasukan\CreateMasterPemasukanController;
use App\Http\Controllers\Master\Pemasukan\DeleteMasterPemasukanController;
use App\Http\Controllers\Master\Pemasukan\UpdateMasterPemasukanController;
use App\Http\Controllers\Master\Pengeluaran\ViewMasterPengeluaranController;
use App\Http\Controllers\Master\Pengeluaran\CreateMasterPengeluaranController;
use App\Http\Controllers\Master\Pengeluaran\DeleteMasterPengeluaranController;
use App\Http\Controllers\Master\Pengeluaran\UpdateMasterPengeluaranController;
use App\Http\Controllers\Views\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

Route::get('/dataTable/jaritan', [DataTableController::class, 'DataJaritan']);
Route::get('/dataTable/pemasukan', [DataTableController::class, 'DataPemasukan']);
Route::get('/dataTable/pengeluaran', [DataTableController::class, 'DataPengeluaran']);




// *** Auth Routes *** //
// --View
Route::get('/login', ViewLoginController::class)->name('login');
Route::prefix('/auth')->group(function () {
    // --Login
    Route::post('/login', LoginController::class)->name('login.auth');

    Route::post('/register', RegisterController::class)->name('register');
    // --Logout
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', LogoutController::class)->name('logout');
    });
});

// *** Master Jaritan Routes *** //
Route::prefix('/mstr/jaritan')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // --View
        Route::get('/all', ViewMasterJaritanController::class)->name('jaritan.all');
        // --Create
        Route::post('/create', CreateMasterJaritanController::class)->name('jaritan.create');
        // --Update
        Route::post('/update/{id}', UpdateMasterJaritanController::class)->name('jaritan.update');
        // --Delete
        Route::delete('/delete/{id}', DeleteMasterJaritanController::class)->name('jaritan.delete');
    });
});

// *** Master Pemasukan Routes *** //
Route::prefix('/mstr/pemasukan')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // --view
        Route::get('/all', ViewMasterPemasukanController::class)->name('pemasukan.all');
        // --create
        Route::post('/create', CreateMasterPemasukanController::class)->name('pemasukan.create');
        // --update
        Route::post('/update/{id}', UpdateMasterPemasukanController::class)->name('pemasukan.update');
        // --delete
        Route::delete('/delete/{id}', DeleteMasterPemasukanController::class)->name('pemasukan.delete');
    });
});

// *** Master Pengeluaran Routes *** //
Route::prefix('/mstr/pengeluaran')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // --view
        Route::get('/all', ViewMasterPengeluaranController::class)->name('pengeluaran.all');
        // --create
        Route::post('/create', CreateMasterPengeluaranController::class)->name('pengeluaran.create');
        // --update
        Route::post('/update/{id}', UpdateMasterPengeluaranController::class)->name('pengeluaran.update');
        // --delete
        Route::delete('/delete/{id}', DeleteMasterPengeluaranController::class)->name('pengeluaran.delete');
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

// *** Pengeluaran Routes *** //
Route::prefix('/pengeluaran')->group(function () {
    // --view
    Route::get('/all', GetAllPengeluaranController::class)->name('pengeluaran.all');
    // --get by id
    Route::get('/detail/{id}', GetDetailPengeluaranController::class)->name('pengeluaran.detail');
    // --search
    Route::post('/search', SearchPengeluaranController::class)->name('pengeluaran.search');
    // --create
    Route::post('/create', CreatePengeluaranController::class)->name('pengeluaran.create');
    // --update
    Route::post('/update/{id}', UpdatePengeluaranController::class)->name('pengeluaran.update');
    // --delete
    Route::delete('/delete/{id}', DeletePengeluaranController::class)->name('pengeluaran.delete');
});


// Route::get('/auth/login', function () {
//     return view('welcome');
// })->name('login');

// // *** View Routes *** //
// Route::middleware('auth:sanctum')->group(function () {
//     // --Dashboard
//     Route::get('/', function () {
//         return view('welcome');
//     })->name('dashboard');
// });




// * Routes Untuk Coba Fitur Tambahan Baru Setengah * //

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});


// Route::get('/', function () {
//     return view('dashboard.index');
// });

Route::get('/mstr/jaritan/all', function () {
    return view('master.jaritan.index');
});
Route::get('/mstr/pemasukan/all', function () {
    return view('master.pemasukan.index');
});
Route::get('/mstr/pengeluaran/all', function () {
    return view('master.pengeluaran.index');
});

// Route::get('/login', function () {
//     return view('sesi.login');
// })->name('login');

// Route::get('/register', function () {
//     return view('sesi.register');
// });



