<?php

namespace App\Http\Controllers\DataTable;

use App\Http\Controllers\Controller;
use App\Models\Master_Pemasukan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataTablePemasukanController extends Controller
{
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
}
