<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Pegawai_Normal;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Pegawai_Rumahan;

class TablePenggajianController extends Controller
{
    public function pegawaiTetap(){
        $coba = Pegawai_Normal::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('pokok', function($data){
            if ($data->gaji_pokok) {
                return 'Rp. '. number_format($data->gaji_pokok) ?? 0;
                
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('final', function($data){
            if ($data->gaji_final) {
                return 'Rp. '. number_format($data->gaji_final) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('kasbon', function($data){
            return 'Rp. '. number_format(optional($data->kasbon_pegawai_tetap)->jumlah_kasbon ?? 0);
        })
        ->addColumn('sisa', function($data){
            return 'Rp. '. number_format(optional($data->kasbon_pegawai_tetap)->sisa ?? 0);
        })
        ->addColumn('aksi', function($data){
            return view('penggajian.gaji-tetap.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }
    public function pegawaiRumahan(){
        $coba = Pegawai_Rumahan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('final', function($data){
            if ($data->gaji_bulanan) {
                return 'Rp. '. number_format($data->gaji_bulanan) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('kasbon', function($data){
            return 'Rp. '. number_format(optional($data->kasbon_pegawai_rumahan)->jumlah_kasbon ?? 0);
        })
        ->addColumn('sisa', function($data){
            return 'Rp. '. number_format(optional($data->kasbon_pegawai_rumahan)->sisa ?? 0);
        })
        ->addColumn('aksi', function($data){
            return view('penggajian.gaji-rumahan.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }

    
}
