<?php

namespace App\Http\Controllers\DataTable;

use App\Models\History;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class TableHistoriesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $coba = History::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('jml', function($data){
            if ($data->jumlah) {
                return 'Rp. '. number_format($data->jumlah) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('tgl', function($data){
            return  date('d-m-Y', strtotime($data->tanggal));
        })
        ->addColumn('aksi', function($data){
            return view('transaksi.keuangan.tombol')->with('data', $data);
        })
        ->make(true);
    }
}
