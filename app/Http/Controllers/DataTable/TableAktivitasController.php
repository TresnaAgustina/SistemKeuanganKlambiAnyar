<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Pegawai_Rumahan;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\ActivityDetail;

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

    public function dataAktivitas(Request $request){

        $id =  $request->id;
        
        $coba = ActivityDetail::where('id_pgwr_activity', $id);
        // $coba = ActivityDetail::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()  
        ->addColumn('nama', function($data){
            return $data->pgwr_activity->pegawai_rumahan->nama;
        })
        ->addColumn('nip', function($data){
            return $data->pgwr_activity->pegawai_rumahan->nip;
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('aksi', function($data){
            return view('aktivitas.view')->with('data', $data);
        })
        ->make(true);
    }
}
