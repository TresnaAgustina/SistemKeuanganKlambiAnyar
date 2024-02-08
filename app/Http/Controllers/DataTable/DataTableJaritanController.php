<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Master_Jaritan;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class DataTableJaritanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $coba = Master_Jaritan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('harga dalam', function($data){
            if ($data->harga_dalam) {
                return 'Rp. '. number_format($data->harga_dalam) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('harga luar', function($data){
            if ($data->harga_luar) {
                return 'Rp. '. number_format($data->harga_luar) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('aksi', function($data){
            return view('master.jaritan.tombol')->with('data', $data);
        })
        ->make(true);
    }
}
