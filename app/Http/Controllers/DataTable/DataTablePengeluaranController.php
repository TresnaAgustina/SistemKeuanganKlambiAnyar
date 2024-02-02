<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Master_Pengeluaran;
use App\Http\Controllers\Controller;

class DataTablePengeluaranController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
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
