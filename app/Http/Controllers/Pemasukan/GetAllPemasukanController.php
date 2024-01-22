<?php

namespace App\Http\Controllers\Pemasukan;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            $data = Pemasukan::all();

            // get nama_atribut from master_pemasukan
            $data->map(function ($item) {
                $item->nama_atribut = $item->master_pemasukan->nama_atribut;
                return $item;
            });

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Success get all data',
                'data' => [
                    'id' => $data->id,
                    'id_mstr_pemasukan' => $data->id_mstr_pemasukan,
                    'nama_atribut' => $data->nama_atribut,
                    'tanggal' => $data->tanggal,
                    'total' => $data->total,
                    'keterangan' => $data->keterangan,
                ]
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
