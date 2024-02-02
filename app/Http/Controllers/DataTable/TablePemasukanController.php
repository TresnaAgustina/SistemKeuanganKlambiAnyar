<?php

namespace App\Http\Controllers\DataTable;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class TablePemasukanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $coba = Pemasukan::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('pemasukan', function($data){
            return $data->master_pemasukan->nama_atribut;
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.pemasukan.tombol')->with('data', $data);
        })
        ->make(true);
    }
}
