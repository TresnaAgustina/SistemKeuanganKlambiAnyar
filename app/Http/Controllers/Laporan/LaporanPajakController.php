<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use App\Models\Penjualan_Lain;
use App\Models\Master_Customer;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Penjualan_Jasa_Jarit;

class LaporanPajakController extends Controller
{
    public function index(){

        $customers = Master_Customer::all();

        // Hitung total penjualan dan keuntungan
        $data = [];
        foreach ($customers as $customer) {
            $totalPenjualan = $customer->penjualan_jasa_jarit->sum('jmlh_dibayar');
            $totalPenjualanLain = $customer->penjualan_lain->sum('jmlh_dibayar');

            $totPenjualan = $totalPenjualan + $totalPenjualanLain;

            $pajak = $totPenjualan * 0.005;

            $data[] = [
                'nama_customer' => $customer->nama_customer,
                'total_penjualan' => $totPenjualan,
                'pajak' => $pajak,
            ];
        } 

        return view('laporan.laporan-pajak.index')->with([
            'data' => $data
        ]);
    }

    public function cetak(Request $request){

        $nama = $request->input('nama');

        // Hitung total penjualan dan pajak
        $customers = Master_Customer::all();
        $data = [];
        $totalPajak = 0; // Inisialisasi total pajak
    
        foreach ($customers as $customer) {
            $totalPenjualan = $customer->penjualan_jasa_jarit->sum('jmlh_dibayar');
            $totalPenjualanLain = $customer->penjualan_lain->sum('jmlh_dibayar');
    
            $totPenjualan = $totalPenjualan + $totalPenjualanLain;
    
            $pajak = $totPenjualan * 0.005;
            $totalPajak += $pajak; // Tambahkan pajak saat ini ke total pajak
    
            $data[] = [
                'nama_customer' => $customer->nama_customer,
                'total_penjualan' => $totPenjualan,
                'pajak' => $pajak,
            ];
        }
    
        $pdf = Pdf::loadview('laporan.laporan-pajak.cetak', [
            'data' => $data,
            'totalPajak' => $totalPajak, // Kirim total pajak ke tampilan PDF
            'nama' => $nama
        ]);
    
        return $pdf->stream();
    }
    
    

    public function cetakPajakTgl($tglawal, $tglakhir, Request $request){
        // dd(["tgl awal :".$tglawal, "tgl Akhir :".$tglakhir]);
        $nama = $request->input('nama');

        $customers = Master_Customer::all();
        $data = [];
        $totalPajak = 0; // Inisialisasi total pajak
    
        foreach ($customers as $customer) {

            $pjl_jasa = $customer->penjualan_jasa_jarit()->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            $pjl_lain = $customer->penjualan_lain()->whereBetween('tanggal', [$tglawal, $tglakhir])->get();

            $totalPenjualan = $pjl_jasa->sum('jmlh_dibayar');
            $totalPenjualanLain = $pjl_lain->sum('jmlh_dibayar');
    
            $totPenjualan = $totalPenjualan + $totalPenjualanLain;
    
            $pajak = $totPenjualan * 0.005;
            $totalPajak += $pajak; // Tambahkan pajak saat ini ke total pajak
    
            $data[] = [
                'nama_customer' => $customer->nama_customer,
                'total_penjualan' => $totPenjualan,
                'pajak' => $pajak,
            ];
        }
    
        $pdf = Pdf::loadview('laporan.laporan-pajak.cetakFilter', [
            'data' => $data,
            'totalPajak' => $totalPajak, // Kirim total pajak ke tampilan PDF
            'tglAwal' => $tglawal,
            'tglAkhir' => $tglakhir,
            'nama' => $nama
        ]);
    
        return $pdf->stream();
    }

    public function config(Request $request) {
        $tglawal = $request->input('tglawal');
        $tglakhir = $request->input('tglakhir');

        // $tglawal = '2024-02-17';
        // $tglakhir = '2024-02-24';


        $customers = Master_Customer::all();

        // Hitung total penjualan dan keuntungan
        $data = [];
        foreach ($customers as $customer) {

            $pjl_jasa = $customer->penjualan_jasa_jarit()->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
            $pjl_lain = $customer->penjualan_lain()->whereBetween('tanggal', [$tglawal, $tglakhir])->get();

            $totalPenjualanJasa = $pjl_jasa->sum('jmlh_dibayar');
            $totalPenjualanLain = $pjl_lain->sum('jmlh_dibayar');

            $totPenjualan = $totalPenjualanJasa + $totalPenjualanLain;

            $pajak = $totPenjualan * 0.005;

            $data[] = [
                'nama_customer' => $customer->nama_customer,
                'total_penjualan' => $totPenjualan,
                'pajak' => $pajak,
            ];
        } 
      
        return response()->json($data);
    }

    // public function config(Request $request) {
    //     $tglawal = $request->input('tglawal');
    //     $tglakhir = $request->input('tglakhir');

    //     // $tglawal = '2024-02-17';
    //     // $tglakhir = '2024-02-24';


    //     $customers = Master_Customer::all();

    //     // Hitung total penjualan dan keuntungan
    //     $data = [];
    //     $totalPajak = 0;
    //     foreach ($customers as $customer) {

    //         $pjl_jasa = $customer->penjualan_jasa_jarit()->whereBetween('tanggal', [$tglawal, $tglakhir])->get();
    //         $pjl_lain = $customer->penjualan_lain()->whereBetween('tanggal', [$tglawal, $tglakhir])->get();

    //         $totalPenjualanJasa = $pjl_jasa->sum('jmlh_dibayar');
    //         $totalPenjualanLain = $pjl_lain->sum('jmlh_dibayar');

    //         $totPenjualan = $totalPenjualanJasa + $totalPenjualanLain;

    //         $pajak = $totPenjualan * 0.005;
    //         $totalPajak += $pajak;

    //         $data[] = [
    //             'nama_customer' => $customer->nama_customer,
    //             'total_penjualan' => $totPenjualan,
    //             'pajak' => $pajak,
    //         ];
    //     } 

    //      // Data total pajak
    //     $totalPajakData = [
    //         'total_pajak' => $totalPajak
    //     ];

    //     // Menggabungkan data total pajak ke dalam data utama
    //     $data[] = $totalPajakData;
      
    //     return response()->json($data);
    // }
}
