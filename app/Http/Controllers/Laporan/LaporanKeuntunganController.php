<?php

namespace App\Http\Controllers\Laporan;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;

class LaporanKeuntunganController extends Controller
{
    public function index(){
        return view('laporan.laporan-keuntungan.index');
    }

    public function cetak(){

        $pemasukan = Pemasukan::all();
        $pengeluaran = Pengeluaran::all();
    
        $totalPemasukan = $pemasukan->sum('total');
        $totalPengeluaran = $pengeluaran->sum('subtotal');
        $keuntungan = $totalPemasukan - $totalPengeluaran;


        $pdf = Pdf::loadview('laporan.laporan-keuntungan.cetak', [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'totPemasukan' => $totalPemasukan,
            'totPengeluaran' => $totalPengeluaran,
            'keuntungan' => $keuntungan
        ]);

        return $pdf->stream();
    }

    public function cetakKeuntunganTgl($tglawal, $tglakhir){
        // dd(["tgl awal :".$tglawal, "tgl Akhir :".$tglakhir]);

        $pemasukan = Pemasukan::whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [$tglawal, $tglakhir])->get();

        $totalPemasukan = $pemasukan->sum('total');
        $totalPengeluaran = $pengeluaran->sum('subtotal');
        $keuntungan = $totalPemasukan - $totalPengeluaran;


        $pdf = Pdf::loadview('laporan.laporan-keuntungan.cetakfilter', [
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'totPemasukan' => $totalPemasukan,
            'totPengeluaran' => $totalPengeluaran,
            'keuntungan' => $keuntungan,
            'tglAwal' => $tglawal,
            'tglAkhir' => $tglakhir
        ]);

        return $pdf->stream();
    }

    public function test(Request $request) {
        $tglawal = $request->input('tglawal');
        $tglakhir = $request->input('tglakhir');
    
        $pemasukan = Pemasukan::whereBetween('tanggal', [$tglawal, $tglakhir])->get();
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [$tglawal, $tglakhir])->get();
    
        $totalPemasukan = $pemasukan->sum('total');
        $totalPengeluaran = $pengeluaran->sum('subtotal');
        $keuntungan = $totalPemasukan - $totalPengeluaran;
    
        $data = [
            'pemasukan' => $totalPemasukan,
            'pengeluaran' => $totalPengeluaran,
            'keuntungan' => $keuntungan
        ];
    
        return response()->json($data);
    }
    
}
