<?php

namespace App\Http\Controllers\DataTable;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class TablePengeluaranController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $coba = Pengeluaran::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        // ->addColumn('pengeluaran', function($data){
        //     return $data->master_pengeluaran->nama_atribut;
        // })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.pengeluaran.tombol')->with('data', $data);
        })
        ->make(true);
    }
}
