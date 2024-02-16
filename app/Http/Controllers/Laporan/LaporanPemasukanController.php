<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Pemasukan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanPemasukanController extends Controller
{
    public function index(){
        return view('laporan.laporan-pemasukan.index');
    }

    public function cetak(){

        $cetak = Pemasukan::all();

        $pdf = Pdf::loadview('laporan.laporan-pemasukan.cetak', ['cetak' => $cetak]);

        return $pdf->stream();
    }

    public function cetakPemasukanTgl($tglawal, $tglakhir){
        // dd(["tgl awal :".$tglawal, "tgl Akhir :".$tglakhir]);

        $cetak = Pemasukan::whereBetween('tanggal', [$tglawal, $tglakhir])->get();

        $pdf = Pdf::loadview('laporan.laporan-pemasukan.cetakfilter', [
            'cetak' => $cetak,
            'tglAwal' => $tglawal,
            'tglAkhir' => $tglakhir
        ]);

        return $pdf->stream();
    }
}
