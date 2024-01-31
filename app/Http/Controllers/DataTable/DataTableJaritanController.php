<?php

namespace App\Http\Controllers\DataTable;

use App\Http\Controllers\Controller;
use App\Models\Master_Jaritan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataTableJaritanController extends Controller
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
}
