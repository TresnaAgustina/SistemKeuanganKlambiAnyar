<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Pegawai_Rumahan;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class TableAktivitasController extends Controller
{
    public function DataPegawai(){
        $coba = Pegawai_Rumahan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('status', function ($data) {
            if ($data->status == "inactive") {
                // return '<span class="label label-success">Aktif</span>';
                return '<span class="badge bg-warning" style="font-size: 12px;">Tidak Aktif</span>';
            } else {
                return '<span class="badge bg-success" style="font-size: 12px;">Aktif</span>';
            }
        }) 
        ->addColumn('aksi', function($data){
            return view('Aktivitas.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }

    public function dataAktivitas(){
        $coba = Pegawai_Rumahan::orderBy('id', 'asc');
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
