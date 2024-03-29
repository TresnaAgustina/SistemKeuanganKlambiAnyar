<?php

use App\Http\Controllers\Aktivitas\CreateActivityController;
use App\Http\Controllers\Aktivitas\GetAllActivityController;
use App\Http\Controllers\Aktivitas\GetDetailActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Gaji\PegawaiRumahan\GetAllGajiRumahanController;
use App\Http\Controllers\Gaji\PegawaiRumahan\GetPotongGajiRumahanController;
use App\Http\Controllers\Gaji\PegawaiRumahan\PotongGajiRumahanController;
use App\Http\Controllers\Gaji\PegawaiTetap\GetAllGajiTetapController;
use App\Http\Controllers\Gaji\PegawaiTetap\GetPotongGajiTetapController;
use App\Http\Controllers\Gaji\PegawaiTetap\PotongGajiTetapController;
use App\Http\Controllers\Keuangan\CreateKeuanganController;
use App\Http\Controllers\Keuangan\DeleteKeuanganController;
use App\Http\Controllers\Keuangan\GetAllKeuanganController;
use App\Http\Controllers\Keuangan\UpdateKeuanganController;
use App\Http\Controllers\Pemasukan\CreatePemasukanController;
use App\Http\Controllers\Pemasukan\DeletePemasukanController;
use App\Http\Controllers\Pemasukan\GetAllPemasukanController;
use App\Http\Controllers\Pemasukan\UpdatePemasukanController;
use App\Http\Controllers\Pemasukan\GetDetailPemasukanController;
use App\Http\Controllers\Pengeluaran\CreatePengeluaranController;
use App\Http\Controllers\Pengeluaran\DeletePengeluaranController;
use App\Http\Controllers\Pengeluaran\GetAllPengeluaranController;
use App\Http\Controllers\Pengeluaran\UpdatePengeluaranController;
use App\Http\Controllers\Master\Barang\CreateMasterBarangController;
use App\Http\Controllers\Master\Barang\DeleteMasterBarangController;
use App\Http\Controllers\Master\Barang\GetAllMasterBarangController;
use App\Http\Controllers\Master\Barang\UpdateMasterBarangController;
use App\Http\Controllers\Master\Jaritan\ViewMasterJaritanController;
use App\Http\Controllers\Pengeluaran\GetDetailPengeluaranController;
use App\Http\Controllers\Master\Jaritan\CreateMasterJaritanController;
use App\Http\Controllers\Master\Jaritan\DeleteMasterJaritanController;
use App\Http\Controllers\Master\Jaritan\UpdateMasterJaritanController;
use App\Http\Controllers\Penjualan_Lain\CreatePenjualanLainController;
use App\Http\Controllers\Penjualan_Lain\DeletePenjualanLainController;
use App\Http\Controllers\Penjualan_Lain\GetAllPenjualanLainController;
use App\Http\Controllers\Master\Customer\CreateMasterCustomerController;
use App\Http\Controllers\Master\Customer\DeleteMasterCustomerController;
use App\Http\Controllers\Master\Customer\GetAllMasterCustomerController;
use App\Http\Controllers\Master\Customer\UpdateMasterCustomerController;
use App\Http\Controllers\Master\Pemasukan\ViewMasterPemasukanController;
use App\Http\Controllers\Master\Pemasukan\CreateMasterPemasukanController;
use App\Http\Controllers\Master\Pemasukan\DeleteMasterPemasukanController;
use App\Http\Controllers\Master\Pemasukan\UpdateMasterPemasukanController;
use App\Http\Controllers\Master\Pengeluaran\ViewMasterPengeluaranController;
use App\Http\Controllers\Master\Pengeluaran\CreateMasterPengeluaranController;
use App\Http\Controllers\Master\Pengeluaran\DeleteMasterPengeluaranController;
use App\Http\Controllers\Master\Pengeluaran\UpdateMasterPengeluaranController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\CreatePgwrTetapController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\DeletePgwrTetapController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\GetAllPgwrTetapController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\UpdatePgwrTetapController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\GetUpdatePgwrTetapController;
use App\Http\Controllers\Penjualan_Jasa_Jarit\CreatePenjualanJasaJaritController;
use App\Http\Controllers\Penjualan_Jasa_Jarit\DeletePenjualanJasaJaritController;
use App\Http\Controllers\Penjualan_Jasa_Jarit\GetAllPenjualanJasaJaritController;

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

// test  Activity
Route::get('/activity/all', GetAllActivityController::class)->name('activity.all');
Route::get('/activity/detail/{id}', GetDetailActivityController::class)->name('activity.detail');
// end test activity

//  test gaji pegawai tetap
Route::prefix('/gaji/pegawai-tetap/')->group( function () {
    Route::get('/all', GetAllGajiTetapController::class)->name('gaji-pegawai-tetap.all');
    Route::get('/detail/{id}', GetPotongGajiTetapController::class)->name('gaji-pegawai-tetap.detail');
    Route::post('/potong-gaji', PotongGajiTetapController::class)->name('gaji-pegawai-tetap.potong');
});
// end test gaji pegawai tetap

// test gaji pegawai rumahan
Route::prefix('/gaji/pegawai-rumahan/')->group( function () {
    Route::get('/all', GetAllGajiRumahanController::class)->name('gaji-pegawai-tetap.all');
    Route::get('/detail/{id}', GetPotongGajiRumahanController::class)->name('gaji-pegawai-tetap.detail');
    Route::post('/potong-gaji', PotongGajiRumahanController::class)->name('gaji-pegawai-tetap.potong');
});
// end test gaji pegawai rumahan

// === *** TESTING BACKEND *** === //

Route::post('/activity/create', CreateActivityController::class)->name('activity.create');

// *** Auth Routes *** //
Route::prefix('/auth')->group(function () {
    Route::post('/login', LoginController::class)->name('login');
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

// *** Master Barang Routes *** //
Route::prefix('/mstr/barang')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // --view
        Route::get('/all', GetAllMasterBarangController::class)->name('barang.all');
        // --create
        Route::post('/create', CreateMasterBarangController::class)->name('barang.create');
        // --update
        Route::post('/update/{id}', UpdateMasterBarangController::class)->name('barang.update');
        // --delete
        Route::delete('/delete/{id}', DeleteMasterBarangController::class)->name('barang.delete');
    });
});

// *** Master Customer Route *** //
Route::prefix('/mstr/customer')->group(function () {
    // --view
    Route::get('/all', GetAllMasterCustomerController::class)->name('customer.all');
    // --create
    Route::post('/create', CreateMasterCustomerController::class)->name('customer.create');
    // --update
    Route::post('/update/{id}', UpdateMasterCustomerController::class)->name('customer.update');
    // --delete
    Route::delete('/delete/{id}', DeleteMasterCustomerController::class)->name('customer.delete');
});


// *** Pemasukan Routes *** //
Route::prefix('/pemasukan')->group(function () {
    // --view
    Route::get('/all', GetAllPemasukanController::class, '__invoke')->name('pemasukan.all');
    // --get by id
    Route::get('/detail/{id}', GetDetailPemasukanController::class)->name('pemasukan.detail');
    // --create
    Route::post('/create', CreatePemasukanController::class)->name('pemasukan.create');
    // --update
    Route::post('/update/{id}', UpdatePemasukanController::class)->name('pemasukan.update');
    // --delete
    Route::delete('/delete/{id}', DeletePemasukanController::class)->name('pemasukan.delete');
});

// *** Master Pegawai Tetap Route *** //
Route::prefix('/mstr/pegawai-tetap')->group(function () {
    // --view
    Route::get('/all', GetAllPgwrTetapController::class)->name('pegawai-tetap.all');
    // --create
    Route::post('/create', CreatePgwrTetapController::class)->name('pegawai-tetap.create');
    // --update
    Route::get('/update/{id}', GetUpdatePgwrTetapController::class)->name('pegawai-tetap.update.index');
    Route::post('/update/{id}', UpdatePgwrTetapController::class)->name('pegawai-tetap.update');
    // --delete
    Route::get('/delete/{id}', DeletePgwrTetapController::class)->name('pegawai-tetap.delete');
});

// *** Pengeluaran Routes *** //
Route::prefix('/pengeluaran')->group(function () {
    // --view
    Route::get('/all', GetAllPengeluaranController::class)->name('pengeluaran.all');
    // --get by id
    Route::get('/detail/{id}', GetDetailPengeluaranController::class)->name('pengeluaran.detail');
    // --create
    Route::post('/create', CreatePengeluaranController::class)->name('pengeluaran.create');
    // --update
    Route::post('/update/{id}', UpdatePengeluaranController::class)->name('pengeluaran.update');
    // --delete
    Route::delete('/delete/{id}', DeletePengeluaranController::class)->name('pengeluaran.delete');
});

// *** Keuangan Route *** //
Route::prefix('/keuangan')->group(function (){
    // --view
    Route::get('/all', GetAllKeuanganController::class)->name('keuangan.all');
    // --create
    Route::post('/create', CreateKeuanganController::class)->name('keuangan.create');
    // --update
    Route::post('/update/{id}', UpdateKeuanganController::class)->name('keuangan.update');
    // --delete
    Route::delete('/delete/{id}', DeleteKeuanganController::class)->name('keuangan.delete');
});

// *** Penjualan_Lain Route *** // - Belum Selesai
Route::prefix('/penjualan-lain')->group(function (){
    // --view
    Route::get('/all', GetAllPenjualanLainController::class)->name('penjualan-lain.all');
    // --create
    Route::post('/create', CreatePenjualanLainController::class)->name('penjualan-lain.create');
    // --delete
    Route::delete('/delete/{id}', DeletePenjualanLainController::class)->name('penjualan-lain.delete'); 
});

Route::prefix('/penjualan-jasa')->group(function (){
    // --view
    Route::get('/all', GetAllPenjualanJasaJaritController::class)->name('penjualan-lain.all');
    // --create
    Route::post('/create', CreatePenjualanJasaJaritController::class)->name('penjualan-lain.create');
    // --delete
    Route::delete('/delete/{id}', DeletePenjualanJasaJaritController::class)->name('penjualan-lain.delete'); 
});

// *** View Routes *** //
// Route::middleware('auth:sanctum')->group(function () {
//     // --Dashboard
//     Route::get('/', function () {
//         return view('welcome');
//     })->name('dashboard');
// });
