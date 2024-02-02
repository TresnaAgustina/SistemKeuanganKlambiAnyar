<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrakOrekController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ViewLoginController;
use App\Http\Controllers\DataTable\DataTableBarangController;
use App\Http\Controllers\Views\DashboardController;
use App\Http\Controllers\DataTable\DataTableController;
use App\Http\Controllers\DataTable\DataTableCustomerController;
use App\Http\Controllers\DataTable\DataTableJaritanController;
use App\Http\Controllers\DataTable\DataTableKeuanganController;
use App\Http\Controllers\DataTable\DataTablePemasukanController;
use App\Http\Controllers\DataTable\DataTablePengeluaranController;
use App\Http\Controllers\DataTable\DataTablePgwrRumahanController;
use App\Http\Controllers\DataTable\DataTablePgwrTetapController;
use App\Http\Controllers\DataTable\TableHistoriesController;
use App\Http\Controllers\DataTable\TablePemasukanController;
use App\Http\Controllers\DataTable\TablePengeluaranController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Keuangan\CreateKeuanganController;
use App\Http\Controllers\Keuangan\DeleteKeuanganController;
use App\Http\Controllers\Keuangan\GetAllKeuanganController;
use App\Http\Controllers\Keuangan\UpdateKeuanganController;
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
use App\Http\Controllers\Master\Barang\CreateMasterBarangController;
use App\Http\Controllers\Master\Barang\DeleteMasterBarangController;
use App\Http\Controllers\Master\Barang\GetAllMasterBarangController;
use App\Http\Controllers\Master\Barang\GetUpdateMasterBarangController;
use App\Http\Controllers\Master\Barang\UpdateMasterBarangController;
use App\Http\Controllers\Master\Customer\CreateMasterCustomerController;
use App\Http\Controllers\Master\Customer\DeleteMasterCustomerController;
use App\Http\Controllers\Master\Customer\GetAllMasterCustomerController;
use App\Http\Controllers\Master\Customer\GetUpdateMasterCustomerController;
use App\Http\Controllers\Master\Customer\UpdateMasterCustomerController;
use App\Http\Controllers\Master\Jaritan\ViewMasterJaritanController;
use App\Http\Controllers\Pengeluaran\GetDetailPengeluaranController;
use App\Http\Controllers\Master\Jaritan\CreateMasterJaritanController;
use App\Http\Controllers\Master\Jaritan\DeleteMasterJaritanController;
use App\Http\Controllers\Master\Jaritan\UpdateMasterJaritanController;
use App\Http\Controllers\Master\Pemasukan\ViewMasterPemasukanController;
use App\Http\Controllers\Master\Jaritan\GetUpdateMasterJaritanController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Rumahan\CreatePgwrRumahanController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Rumahan\DeletePgwrRumahanController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Rumahan\GetAllPgwrRumahanController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Rumahan\GetUpdatePgwrRumahanController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Rumahan\UpdatePgwrRumahanController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\CreatePgwrTetapController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\DeletePgwrTetapController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\GetAllPgwrTetapController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\GetUpdatePgwrTetapController;
use App\Http\Controllers\Master\Pegawai\Pegawai_Tetap\UpdatePgwrTetapController;
use App\Http\Controllers\Master\Pemasukan\CreateMasterPemasukanController;
use App\Http\Controllers\Master\Pemasukan\DeleteMasterPemasukanController;
use App\Http\Controllers\Master\Pemasukan\UpdateMasterPemasukanController;
use App\Http\Controllers\Master\Pengeluaran\ViewMasterPengeluaranController;
use App\Http\Controllers\Master\Pemasukan\GetUpdateMasterPemasukanController;
use App\Http\Controllers\Master\Pengeluaran\CreateMasterPengeluaranController;
use App\Http\Controllers\Master\Pengeluaran\DeleteMasterPengeluaranController;
use App\Http\Controllers\Master\Pengeluaran\UpdateMasterPengeluaranController;
use App\Http\Controllers\Master\Pengeluaran\GetUpdateMasterPengeluaranController;

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

// -- Data Table Config --
// Route::get('/dataTable/jaritan', [DataTableController::class, 'DataJaritan']);
// Route::get('/dataTable/pemasukan', [DataTableController::class, 'DataPemasukan']);
// Route::get('/dataTable/pengeluaran', [DataTableController::class, 'DataPengeluaran']);
// Route::get('/dataTable/DataPemasukan', [DataTableController::class, 'Pemasukan']);
// Route::get('/dataTable/DataPengeluaran', [DataTableController::class, 'Pengeluaran']);
// Route::get('/dataTable/PegawaiTetap', [DataTableController::class, 'PegawaiTetap']);
// Route::get('/dataTable/PegawaiRumahan', [DataTableController::class, 'PegawaiRumahan']);
// Route::get('/dataTable/customer', [DataTableController::class, 'customer']);
// Route::get('/dataTable/barang', [DataTableController::class, 'barang']);

Route::prefix('/dataTable')->group(function () {
    Route::get('/jaritan', DataTableJaritanController::class)->name('dataTable.jaritan');
    Route::get('/pemasukan', DataTablePemasukanController::class)->name('dataTable.pemasukan');
    Route::get('/pengeluaran', DataTablePengeluaranController::class)->name('dataTable.pengeluaran');
    Route::get('/DataPemasukan', TablePemasukanController::class)->name('dataTable.dataPemasukan');
    Route::get('/DataPengeluaran', TablePengeluaranController::class)->name('dataTable.dataPengeluaran');
    Route::get('/PegawaiTetap', DataTablePgwrTetapController::class)->name('dataTable.pegawaiTetap');
    Route::get('/PegawaiRumahan', DataTablePgwrRumahanController::class)->name('dataTable.pegawaiRumahan');
    Route::get('/customer', DataTableCustomerController::class)->name('dataTable.customer');
    Route::get('/barang', DataTableBarangController::class)->name('dataTable.barang');
    Route::get('/keuangan', DataTableKeuanganController::class)->name('dataTable.keuangan');
    Route::get('/histori', TableHistoriesController::class)->name('dataTable.histori');
});


// *** Auth Routes *** //
// --View
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/login', ViewLoginController::class)->name('login');
Route::prefix('/auth')->group(function () {
    // --Login
    Route::post('/login', LoginController::class)->name('login.auth');

    Route::post('/register', RegisterController::class)->name('register');
    // --Logout
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/logout', LogoutController::class)->name('logout');
    });
});

// *** Master Jaritan Routes *** //
Route::prefix('/mstr/jaritan')->group(function () {
    // --View
    Route::get('/all', ViewMasterJaritanController::class)->name('jaritan.all');
    Route::get('/update/{id}', GetUpdateMasterJaritanController::class)->name('jaritan.update.index');
    // --Create
    Route::post('/create', CreateMasterJaritanController::class)->name('jaritan.create');
    // --Update
    Route::post('/update/{id}', UpdateMasterJaritanController::class)->name('jaritan.update');
    // --Delete
    Route::delete('/delete/{id}', DeleteMasterJaritanController::class)->name('jaritan.delete');
});

// *** Master Pemasukan Routes *** //
Route::prefix('/mstr/pemasukan')->group(function () {
    // --view
    Route::get('/all', ViewMasterPemasukanController::class)->name('pemasukan.all');
    Route::get('/update/{id}', GetUpdateMasterPemasukanController::class)->name('pemasukan.update.index');
    // --create
    Route::post('/create', CreateMasterPemasukanController::class)->name('pemasukan.create');
    // --update
    Route::post('/update/{id}', UpdateMasterPemasukanController::class)->name('pemasukan.update');
    // --delete
    Route::delete('/delete/{id}', DeleteMasterPemasukanController::class)->name('pemasukan.delete');
});

// *** Master Pengeluaran Routes *** //
Route::prefix('/mstr/pengeluaran')->group(function () {
    // --view
    Route::get('/all', ViewMasterPengeluaranController::class)->name('pengeluaran.all');
    Route::get('/update/{id}', GetUpdateMasterPengeluaranController::class)->name('pengeluaran.update.index');
    // --create
    Route::post('/create', CreateMasterPengeluaranController::class)->name('pengeluaran.create');
    // --update
    Route::post('/update/{id}', UpdateMasterPengeluaranController::class)->name('pengeluaran.update');
    // --delete
    Route::delete('/delete/{id}', DeleteMasterPengeluaranController::class)->name('pengeluaran.delete');
});

// *** Master Barang Routes *** //
Route::prefix('/mstr/barang')->group(function () {
    // --view
    Route::get('/all', GetAllMasterBarangController::class)->name('barang.all');
    // --create
    Route::post('/create', CreateMasterBarangController::class)->name('barang.create');
    // --update
    Route::get('/update/{id}', GetUpdateMasterBarangController::class)->name('barang.update.index');
    Route::post('/update/{id}', UpdateMasterBarangController::class)->name('barang.update');
    // --delete
    Route::delete('/delete/{id}', DeleteMasterBarangController::class)->name('barang.delete');
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

// *** Master Pegawai Rumahan Route *** //
Route::prefix('/mstr/pegawai-rumahan')->group(function () {
    // --view
    Route::get('/all', GetAllPgwrRumahanController::class)->name('pegawai-rumahan.all');
    // --create
    Route::post('/create', CreatePgwrRumahanController::class)->name('pegawai-rumahan.create');
    // --update
    Route::get('/update/{id}', GetUpdatePgwrRumahanController::class)->name('pegawai-rumahan.update.index');
    Route::post('/update/{id}', UpdatePgwrRumahanController::class)->name('pegawai-rumahan.update');
    // --delete
    Route::get('/delete/{id}', DeletePgwrRumahanController::class)->name('pegawai-rumahan.delete');
});

// *** Master Customer Route *** //
Route::prefix('/mstr/customer')->group(function () {
    // --view
    Route::get('/all', GetAllMasterCustomerController::class)->name('customer.all');
    // --create
    Route::post('/create', CreateMasterCustomerController::class)->name('customer.create');
    // --update
    Route::get('/update/{id}', GetUpdateMasterCustomerController::class)->name('customer.update.index');
    Route::post('/update/{id}', UpdateMasterCustomerController::class)->name('customer.update');
    // --delete
    Route::delete('/delete/{id}', DeleteMasterCustomerController::class)->name('customer.delete');
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


// coba test fitur keuangan 

// Route::get('/keuangan/all', function(){
//     return view('keuangan.index');
// });









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


// Route::get('/register', function () {
//     return view('sesi.register');
// });



