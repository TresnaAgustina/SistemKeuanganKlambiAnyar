<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Master_Jaritan;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Master_Pemasukan;
use App\Models\Master_Pengeluaran;

class DataTableController extends Controller
{
    public function DataJaritan()
    {
        $coba = Master_Jaritan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('master.jaritan.tombol')->with('data', $data);
        })
        ->make(true);
    }

    public function DataPemasukan()
    {
        $coba = Master_Pemasukan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('master.pemasukan.tombol')->with('data', $data);
        })
        ->make(true);
    }
    public function DataPengeluaran()
    {
        $coba = Master_Pengeluaran::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('aksi', function($data){
            return view('master.pengeluaran.tombol')->with('data', $data);
        })
        ->make(true);
    }

    // public function test(){
    //     return 'test';
    // }

}
