<?php

namespace App\Http\Controllers\DataTable;

use Illuminate\Http\Request;
use App\Models\Master_Barang;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class DataTableBarangController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $coba = Master_Barang::orderBy('id', 'asc');
        return DataTables::of($coba)
        ->addIndexColumn()
        ->addColumn('harga beli', function($data){
            if ($data->harga_beli) {
                return 'Rp. '. number_format($data->harga_beli) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('harga jual', function($data){
            if ($data->harga_jual) {
                return 'Rp. '. number_format($data->harga_jual) ?? 0;
            } else {
                return 'Rp. ' . 0;
            }
        })
        ->addColumn('aksi', function($data){
            return view('Master.barang.tombol')->with('data', $data);
        })
        ->make(true);
    }
}
