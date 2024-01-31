<?php

namespace App\Http\Controllers\DataTable;

use App\Http\Controllers\Controller;
use App\Models\Master_Pengeluaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataTablePengeluaranController extends Controller
{
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
}
