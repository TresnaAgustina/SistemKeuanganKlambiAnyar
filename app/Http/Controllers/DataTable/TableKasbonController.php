<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Kasbon_Pegawai;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\KasbonPgwRumahan;
use App\Models\KasbonPgwTetap;

class TableKasbonController extends Controller
{
    public function kasbonPegawaiTetap(){
        $coba = KasbonPgwTetap::all();
        // $coba = Kasbon_Pegawai::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->pegawai_normal->nama;
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('jumlah', function($data){
            if ($data->jumlah_kasbon) {
                return 'Rp. '. number_format($data->jumlah_kasbon) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('sisa', function($data){
            if ($data->sisa) {
                return 'Rp. '. number_format($data->sisa) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('status', function ($data) {
            if ($data->status == 'belum lunas') {
                // return '<span class="label label-success">Aktif</span>';
                return '<span class="badge bg-warning" style="font-size: 12px;">Belum Lunas</span>';
            } else {
                return '<span class="badge bg-success" style="font-size: 12px;">Lunas</span>';
            }
        }) 
        ->addColumn('aksi', function($data){
            return view('kasbon.kasbon-tetap.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }

    public function kasbonPegawaiRumahan(){
        $coba = KasbonPgwRumahan::all();
        // $coba = Kasbon_Pegawai::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->pegawai_rumahan->nama;
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('jumlah', function($data){
            if ($data->jumlah_kasbon) {
                return 'Rp. '. number_format($data->jumlah_kasbon) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('sisa', function($data){
            if ($data->sisa) {
                return 'Rp. '. number_format($data->sisa) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('status', function ($data) {
            if ($data->status == 'belum lunas') {
                // return '<span class="label label-success">Aktif</span>';
                return '<span class="badge bg-warning" style="font-size: 12px;">Belum Lunas</span>';
            } else {
                return '<span class="badge bg-success" style="font-size: 12px;">Lunas</span>';
            }
        }) 
        ->addColumn('aksi', function($data){
            return view('kasbon.kasbon-rumahan.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }
}
