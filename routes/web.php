<?php

use App\Http\Controllers\Aktivitas\CreateActivityController;
use App\Http\Controllers\Aktivitas\CreateAktivitasController;
use App\Http\Controllers\Aktivitas\GetAllActivityController;
use App\Http\Controllers\Aktivitas\GetAllAktivitasController;
use App\Http\Controllers\Aktivitas\GetCreateAktivitasController;
use App\Http\Controllers\Aktivitas\GetDetailActivityController;
use App\Http\Controllers\Aktivitas\GetDetailAktivitasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ViewLoginController;
use App\Http\Controllers\DataTable\DataMasterController;
use App\Http\Controllers\Views\DashboardController;
use App\Http\Controllers\DataTable\DataTransaksi;
use App\Http\Controllers\DataTable\TableAktivitasController;
use App\Http\Controllers\DataTable\TableHistoriesController;
use App\Http\Controllers\DataTable\TableKasbonController;
use App\Http\Controllers\DataTable\TableLaporanController;
use App\Http\Controllers\DataTable\TablePenggajianController;
use App\Http\Controllers\DataTable\TablePenjualanController;
use App\Http\Controllers\Gaji\PegawaiRumahan\GetPotongGajiRumahanController;
use App\Http\Controllers\Gaji\PegawaiRumahan\PotongGajiRumahanController;
use App\Http\Controllers\Gaji\PegawaiTetap\GetPotongGajiTetapController;
use App\Http\Controllers\Gaji\PegawaiTetap\PotongGajiTetapController;
use App\Http\Controllers\Hutang\CreateHutangController;
use App\Http\Controllers\Hutang\GetAllHutangController;
use App\Http\Controllers\Hutang\GetUpdateHutangController;
use App\Http\Controllers\Hutang\UpdateHutangController;
use App\Http\Controllers\Kasbon\Kasbon_Rumahan\GetAllKasbonRumahanController;
use App\Http\Controllers\Kasbon\Kasbon_Rumahan\GetViewBayarKasbonRumahanController;
use App\Http\Controllers\Kasbon\Kasbon_Tetap\GetAllKasbonTetapController;
use App\Http\Controllers\Kasbon\Kasbon_Tetap\GetViewBayarKasbonTetapController;
use App\Http\Controllers\Kasbon\PegawaiRumahan\CreateKasbonController;
use App\Http\Controllers\Keuangan\CreateKeuanganController;
use App\Http\Controllers\Keuangan\DeleteKeuanganController;
use App\Http\Controllers\Keuangan\GetAllKeuanganController;
use App\Http\Controllers\Keuangan\HitungController;
use App\Http\Controllers\Keuangan\UpdateKeuanganController;
use App\Http\Controllers\Laporan\LaporanKeuntunganController;
use App\Http\Controllers\Laporan\LaporanPajakController;
use App\Http\Controllers\Laporan\LaporanPemasukanController;
use App\Http\Controllers\Laporan\LaporanPengeluaranController;
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
use App\Http\Controllers\Penggajian\Gaji_Rumahan\GetAllGajiRumahanController;
use App\Http\Controllers\Penggajian\Gaji_Rumahan\GetViewBayarGajiRumahanController;
use App\Http\Controllers\Penggajian\Gaji_Tetap\GetAllGajiTetapController;
use App\Http\Controllers\Penggajian\Gaji_Tetap\GetViewBayarGajiTetapController;
use App\Http\Controllers\Penjualan_Jasa_Jarit\CreatePenjualanJasaJaritController;
use App\Http\Controllers\Penjualan_Jasa_Jarit\GetAllPenjualanJasaJaritController;
use App\Http\Controllers\Penjualan_Jasa_Jarit\GetDetailPenjualanJasaJaritController;
use App\Http\Controllers\Penjualan_Jasa_Jarit\GetUpdatePenjualanJasaJaritController;
use App\Http\Controllers\Penjualan_Lain\CreatePenjualanLainController;
use App\Http\Controllers\Penjualan_Lain\GetAllPenjualanLainController;
use App\Http\Controllers\Penjualan_Lain\GetDetailPenjualLainController;
use App\Http\Controllers\Penjualan_Lain\GetUpdatePenjualanLainController;
use App\Http\Controllers\Piutang\GetAllPiutangController;
use App\Http\Controllers\Piutang\GetUpdatePiutangController;
use App\Http\Controllers\Piutang\UpdatePiutangController;
use App\Http\Controllers\Kasbon\PegawaiRumahan;
use App\Http\Controllers\Kasbon\PegawaiTetap;

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

Route::prefix('/dataTable')->group(function () {
    Route::get('/customer', [DataMasterController::class, 'MasterCustomer'] )->name('dataTable.customer');
    Route::get('/PegawaiTetap', [DataMasterController::class, 'MasterPegawaiTetap'] )->name('dataTable.pegawaiTetap');
    Route::get('/PegawaiRumahan', [DataMasterController::class, 'MasterPegawaiRumahan'] )->name('dataTable.pegawaiRumahan');
    Route::get('/jaritan', [DataMasterController::class, 'MasterJaritan'])->name('dataTable.jaritan');
    Route::get('/barang', [DataMasterController::class, 'MasterBarang'] )->name('dataTable.barang');
    Route::get('/pemasukan', [DataMasterController::class, 'MasterPemasukan'] )->name('dataTable.pemasukan');
    Route::get('/pengeluaran',[DataMasterController::class, 'MasterPengeluaran'] )->name('dataTable.pengeluaran');
    Route::get('/DataPemasukan',[DataTransaksi::class, 'pemasukan'] )->name('dataTable.dataPemasukan');
    Route::get('/DataPengeluaran',[DataTransaksi::class, 'pengeluaran'] )->name('dataTable.dataPengeluaran');
    Route::get('/keuangan',[DataTransaksi::class, 'keuangan'] )->name('dataTable.keuangan');
    Route::get('/histori', TableHistoriesController::class)->name('dataTable.histori');
    Route::get('/piutang',[DataTransaksi::class, 'piutang'] )->name('dataTable.piutang');
    Route::get('/hutang',[DataTransaksi::class, 'hutang'] )->name('dataTable.hutang');
    Route::get('/penjualan-jasa', [TablePenjualanController::class, 'penjualanJasa'])->name('dataTable.penjualan-jasa');
    Route::get('/penjualan-lain', [TablePenjualanController::class, 'penjualanLain'])->name('dataTable.penjualan-lain');
    Route::get('/PegawaiAktivitas', [TableAktivitasController::class, 'DataPegawai'])->name('dataTable.DataPegawaiAktivitas');
    Route::get('/Aktivitas', [TableAktivitasController::class, 'dataAktivitas'])->name('dataTable.dataAktivitas');
    Route::get('/KasbonTetap', [TableKasbonController::class, 'kasbonPegawaiTetap'])->name('dataTable.kasbonTetap');
    Route::get('/KasbonRumahan', [TableKasbonController::class, 'kasbonPegawaiRumahan'])->name('dataTable.kasbonRumahan');
    Route::get('/gajiTetap', [TablePenggajianController::class, 'pegawaiTetap'])->name('dataTable.gajiTetap');
    Route::get('/gajiRumahan', [TablePenggajianController::class, 'pegawaiRumahan'])->name('dataTable.gajiRumahan');
    Route::post('/LaporanPemasukan', [TableLaporanController::class, 'DataPemasukan'])->name('dataTable.laporanPemasukan');
    Route::post('/LaporanPengeluaran', [TableLaporanController::class, 'DataPengeluaran'])->name('dataTable.laporanPengeluaran');
    Route::post('/LaporanPajak', [TableLaporanController::class, 'pajak'])->name('dataTable.laporanPajak');
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
    Route::post('/saldo-bank', [HitungController::class , 'saldoBank']);
    Route::post('/saldo-kas', [HitungController::class , 'saldoKas']);
    Route::post('/transfer-bank', [HitungController::class , 'trfBank']);
    Route::post('/transfer-kas', [HitungController::class , 'trfKas']);
});

Route::prefix('/penjualan-lain')->group(function(){
    Route::get('/all', GetAllPenjualanLainController::class)->name('penjualanLain.all');
    Route::post('/create', CreatePenjualanLainController::class)->name('penjualanLain.create');
    Route::get('/update/{id}', GetUpdatePenjualanLainController::class)->name('penjualanLain.update.index');
    Route::get('/detail/{kode_penjualan}', GetDetailPenjualLainController::class)->name('penjualanLain.Detail.index');
});
Route::prefix('/penjualan-jasa')->group(function(){
    Route::get('/all', GetAllPenjualanJasaJaritController::class)->name('penjualanJasa.all');
    Route::post('/create', CreatePenjualanJasaJaritController::class)->name('penjualanJasa.create');
    Route::get('/update/{id}', GetUpdatePenjualanJasaJaritController::class)->name('penjualanJasa.update.index');
    Route::get('/detail/{kode_penjualan}', GetDetailPenjualanJasaJaritController::class)->name('penjualanJasa.update.index');

});
Route::prefix('/piutang')->group(function(){
    Route::get('/all', GetAllPiutangController::class)->name('piutang.all');
    Route::get('/bayar/{id}', GetUpdatePiutangController::class)->name('piutang.update.index');
    Route::post('/bayar/{id}', UpdatePiutangController::class)->name('piutang.update');
});
Route::prefix('/hutang')->group(function(){
    Route::get('/all', GetAllHutangController::class)->name('hutang.all');
    Route::post('/create', CreateHutangController::class)->name('hutang.create');
    Route::get('/bayar/{id}', GetUpdateHutangController::class)->name('hutang.update.index');
    Route::post('/bayar/{id}', UpdateHutangController::class)->name('hutang.update');
});
Route::prefix('/aktivitas')->group(function(){
    Route::get('/all', GetAllActivityController::class)->name('aktivitas.all');
    Route::get('/create/{nip}', GetCreateAktivitasController::class)->name('aktivitas.create.index');
    Route::post('/create/{nip}', CreateActivityController::class)->name('aktivitas.create');
    Route::get('/detail/{id}', GetDetailAktivitasController::class)->name('activity.detail');

    // Route::post('/bayar/{id}', UpdatePiutangController::class)->name('hutang.update');
});
Route::prefix('/laporan-pemasukan')->group(function(){
    Route::get('/all', [LaporanPemasukanController::class, 'index'])->name('laporan-pemasukan.all');
    Route::get('/cetak', [LaporanPemasukanController::class, 'cetak'])->name('laporan-pemasukan.cetak');
    Route::get('/{in}/{out}', [LaporanPemasukanController::class, 'cetakPemasukanTgl'])->name('laporan-pemasukan.cetakFilter');
});
Route::prefix('/laporan-pengeluaran')->group(function(){
    Route::get('/all', [LaporanPengeluaranController::class, 'index'])->name('laporan-pengeluaran.all');
    Route::get('/cetak', [LaporanPengeluaranController::class, 'cetak'])->name('laporan-pengeluaran.cetak');
    Route::get('/{in}/{out}', [LaporanPengeluaranController::class, 'cetakPengeluaranTgl'])->name('laporan-pengeluaran.cetakFilter');
});
Route::prefix('/laporan-keuntungan')->group(function(){
    Route::get('/all', [LaporanKeuntunganController::class, 'index'])->name('laporan-keuntungan.all');
    Route::get('/cetak', [LaporanKeuntunganController::class, 'cetak'])->name('laporan-keuntungan.cetak');
    Route::get('/{in}/{out}', [LaporanKeuntunganController::class, 'cetakKeuntunganTgl'])->name('laporan-keuntungan.cetakFilter');
    Route::get('/test', [LaporanKeuntunganController::class, 'test'])->name('laporan-keuntungan.cetakFilter');
});
Route::prefix('/laporan-pajak')->group(function(){
    Route::get('/all', [LaporanPajakController::class, 'index'])->name('laporan-pajak.all');
    Route::get('/cetak', [LaporanPajakController::class, 'cetak'])->name('laporan-pajak.cetak');
    Route::get('/{in}/{out}', [LaporanPajakController::class, 'cetakPajakTgl'])->name('laporan-pajak.cetakFilter');
    Route::get('/config', [LaporanPajakController::class, 'config'])->name('laporan-pajak.cetakFilter');
});
Route::prefix('/kasbon-tetap')->group(function(){
    Route::get('/all', GetAllKasbonTetapController::class)->name('kasbon-tetap.all');
    Route::post('/create', PegawaiTetap\CreateKasbonController::class)->name('gaji-tetap.create');
    Route::get('/bayar/{id}', GetViewBayarKasbonTetapController::class)->name('kasbon-tetap.bayar.index');
    Route::post('/bayar/{id}', PegawaiTetap\BayarKasbonController::class)->name('gaji-tetap.bayar');
});
Route::prefix('/kasbon-rumahan')->group(function(){
    Route::get('/all', GetAllKasbonRumahanController::class)->name('kasbon-rumahan.all');
    Route::post('/create', PegawaiRumahan\CreateKasbonController::class)->name('kasbon-rumahan.create');
    Route::get('/bayar/{id}', GetViewBayarKasbonRumahanController::class)->name('kasbon-rumahan.bayar.index');
    Route::post('/bayar/{id}', PegawaiRumahan\BayarKasbonController::class)->name('kasbon-rumahan.bayar');
});
// Route::prefix('/gaji-tetap')->group(function(){
//     Route::get('/all', GetAllGajiTetapController::class)->name('gaji-tetap.all');
//     Route::get('/bayar/{id}', GetViewBayarGajiTetapController::class)->name('gaji-tetap.bayar.index');
   
// });
// Route::prefix('/gaji-rumahan')->group(function(){
//     Route::get('/all', GetAllGajiRumahanController::class)->name('gaji-rumahan.all');
//     Route::get('/bayar/{id}', GetViewBayarGajiRumahanController::class)->name('gaji-rumahan.bayar.index');
   
// });


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



// coba test fitur keuangan

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



