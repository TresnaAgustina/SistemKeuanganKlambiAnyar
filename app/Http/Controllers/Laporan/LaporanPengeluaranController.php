<?php

namespace App\Http\Controllers\Laporan;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class LaporanPengeluaranController extends Controller
{
    public function index(){
        return view('laporan.laporan-pengeluaran.index');
    }

    public function cetak(){

        $cetak = Pengeluaran::all();

        $pdf = Pdf::loadview('laporan.laporan-pengeluaran.cetak', ['cetak' => $cetak]);

        return $pdf->stream();
    }

    public function cetakPengeluaranTgl($tglawal, $tglakhir){
        // dd(["tgl awal :".$tglawal, "tgl Akhir :".$tglakhir]);

        $cetak = Pengeluaran::whereBetween('tanggal', [$tglawal, $tglakhir])->get();

        $pdf = Pdf::loadview('laporan.laporan-pengeluaran.cetakfilter', [
            'cetak' => $cetak,
            'tglAwal' => $tglawal,
            'tglAkhir' => $tglakhir
        ]);

        return $pdf->stream();
    }
}
