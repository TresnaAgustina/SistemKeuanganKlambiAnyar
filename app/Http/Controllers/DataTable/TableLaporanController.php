<?php

namespace App\Http\Controllers\DataTable;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class TableLaporanController extends Controller
{
    public function DataPemasukan(){
        $coba = Pemasukan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('nama', function($data){
            return $data->master_pemasukan->nama_atribut;
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
        ->make(true);
    }
}
