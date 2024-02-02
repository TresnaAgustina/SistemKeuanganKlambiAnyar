<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Pegawai_Rumahan;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class DataTablePgwrRumahanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
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
            return view('Master.pegawai-rumahan.tombol')->with('data', $data);
        })
        ->rawColumns(['status'])
        ->make(true);
    }
}