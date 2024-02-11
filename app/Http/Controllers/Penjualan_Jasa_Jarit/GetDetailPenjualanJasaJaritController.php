<?php

namespace App\Http\Controllers\Penjualan_Jasa_Jarit;

use App\Http\Controllers\Controller;
use App\Models\CartPenjualanJasa;
use App\Models\Penjualan_Jasa_Jarit;
use Illuminate\Http\Request;

class GetDetailPenjualanJasaJaritController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $kode)
    {
        try {
            // get data id
            $data = Penjualan_Jasa_Jarit::where('kode_penjualan', $kode)->first();
            $id = $data->id;

            $penjualan = CartPenjualanJasa::where('id_penjualan_jasa', $id)->get();
            
            // if data empty
            if (!$data) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }
            // return data
            // return response()->json([
            //     'result' => $data
            // ], 200);

            return view('penjualan.penjualan-jasa.detail')->with([
                'data' => $data,
                'penjualan' => $penjualan
            ]);

        //    dd($penjualan);
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
