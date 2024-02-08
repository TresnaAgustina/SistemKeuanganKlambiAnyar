<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Penjualan_Jasa_Jarit;
use App\Models\Penjualan_Lain;

class TablePenjualanController extends Controller
{
    public function penjualanJasa(){
        $coba = Penjualan_Jasa_Jarit::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->customer->nama_customer;
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('bayarAwal', function($data){
            if ($data->jmlh_bayar_awal) {
                return 'Rp. '. number_format($data->jmlh_bayar_awal) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('dibayar', function($data){
            if ($data->jmlh_dibayar) {
                return 'Rp. '. number_format($data->jmlh_dibayar) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('aksi', function($data){
            return view('penjualan.penjualan-jasa.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function penjualanLain(){
        $coba = Penjualan_Lain::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->customer->nama_customer;
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('bayarAwal', function($data){
            if ($data->jmlh_bayar_awal) {
                return 'Rp. '. number_format($data->jmlh_bayar_awal) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('dibayar', function($data){
            if ($data->jmlh_dibayar) {
                return 'Rp. '. number_format($data->jmlh_dibayar) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('aksi', function($data){
            return view('penjualan.penjualan-jasa.tombol')->with('data', $data);
        })
        ->make(true);
    }
}
