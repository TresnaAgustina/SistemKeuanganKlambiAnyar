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
        ->addColumn('total', function($data){
            if ($data->total) {
                return 'Rp. '. number_format($data->total) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('nama', function($data){
           return $data->master_pemasukan->nama_pemasukan;
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
        // ->addColumn('pengeluaran', function($data){
        //     return $data->master_pengeluaran->nama_atribut;
        // })
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
        ->addColumn('aksi', function($data){
            return view('Master.barang.tombol')->with('data', $data);
        })
        ->make(true);
    }

    
    public function piutang(){
        $coba = Piutang::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
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
