<?php

namespace App\Http\Controllers\DataTable;

use App\Models\Piutang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Hutang;
use App\Models\Keuangan;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;

class DataTransaksi extends Controller
{
    public function keuangan(){
        $coba = Keuangan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('bank', function($data){
            if ($data->jumlah) {
                return 'Rp. '. number_format($data->jumlah) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.keuangan.tombol')->with('data', $data);
        })
        ->make(true);
    }


    public function pemasukan(){
        $coba = Pemasukan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->master_pemasukan->nama_atribut;
         })
        ->addColumn('metode_pembayaran', function($data){
            return $data->metode_pembayaran;
         })
        ->addColumn('total', function($data){
            if ($data->total) {
                return 'Rp. '. number_format($data->total) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.pemasukan.tombol')->with('data', $data);
        })
        ->make(true);
    }


    public function pengeluaran(){
        $coba = Pengeluaran::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->master_pengeluaran->nama_atribut;
         })
        ->addColumn('total', function($data){
            if ($data->subtotal) {
                return 'Rp. '. number_format($data->subtotal) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.pengeluaran.tombol')->with('data', $data);
        })
        ->make(true);
    }


    public function hutang(){
        $coba = Hutang::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->pengeluaran->master_pengeluaran->nama_atribut;
        })
        ->addColumn('status', function ($data) {
            if ($data->status == 'Belum Lunas') {
                // return '<span class="label label-success">Aktif</span>';
                return '<span class="badge bg-warning" style="font-size: 12px;">Belum Lunas</span>';
            } else {
                return '<span class="badge bg-success" style="font-size: 12px;">Lunas</span>';
            }
        }) 
        
        ->addColumn('sisa', function($data){
            if ($data->sisa_hutang) {
                return 'Rp. '. number_format($data->sisa_hutang) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('jumlah', function($data){
            if ($data->jumlah_hutang) {
                return 'Rp. '. number_format($data->jumlah_hutang) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.hutang.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }

    
    public function piutang(){
        $coba = Piutang::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            if ($data->id_jual_lain) {
                return $data->penjualan_lain->customer->nama_customer;
            } else {
                return $data->penjualan_jasa_jarit->customer->nama_customer;
            }
        })
        ->addColumn('status', function ($data) {
            if ($data->status == 'Belum Lunas') {
                // return '<span class="label label-success">Aktif</span>';
                return '<span class="badge bg-warning" style="font-size: 12px;">Belum Lunas</span>';
            } else {
                return '<span class="badge bg-success" style="font-size: 12px;">Lunas</span>';
            }
        }) 
        
        ->addColumn('sisa', function($data){
            if ($data->sisa_piutang) {
                return 'Rp. '. number_format($data->sisa_piutang) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('jumlah', function($data){
            if ($data->jumlah_piutang) {
                return 'Rp. '. number_format($data->jumlah_piutang) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.piutang.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }
}
