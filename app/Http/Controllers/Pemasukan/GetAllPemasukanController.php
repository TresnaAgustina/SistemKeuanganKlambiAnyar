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
                    'master_pemasukan.nama_atribut',
                    'pemasukan.tanggal',
                    'pemasukan.total',
                    'pemasukan.keterangan',
                )
                ->get();


            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully get all pemasukan',
                'data' => $data
            ], 200);

            // for monolith app
            // return view('pemasukan.index', compact('data'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'data' => Null
            ], 500);

            // for monolith app
            // return redirect()->back()->with(
            //     'error', 'Error: ' . $e->getMessage()
            // );
        }
    }
}
