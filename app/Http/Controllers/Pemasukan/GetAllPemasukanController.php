<?php

namespace App\Http\Controllers\Pemasukan;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master_Pemasukan;

class GetAllPemasukanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            //get all data from database
            $data = Pemasukan::join('master_pemasukan', 'pemasukan.id_mstr_pemasukan', '=', 'master_pemasukan.id')
                ->select(
                    'pemasukan.id',
                    'pemasukan.id_mstr_pemasukan',
                    'master_pemasukan.nama_atribut as nama_pemasukan',
                    'pemasukan.tanggal',
                    'pemasukan.total',
                    'pemasukan.keterangan',
                )
                ->get();
            
            $pemasukan = Master_Pemasukan::all();

            // return response()->json([
            //     'status' => 'success',
            //     'data' => $data,
            //     'pemasukan' => $pemasukan
            // ]);

            return view('transaksi.pemasukan.index')->with([
                'data' => $data,
                'pemasukan' => $pemasukan
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error', 'Error: ' . $e->getMessage()
            );
        }
    }
}
