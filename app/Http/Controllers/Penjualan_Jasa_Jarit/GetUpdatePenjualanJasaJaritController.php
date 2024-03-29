<?php

namespace App\Http\Controllers\Penjualan_Jasa_Jarit;

use App\Http\Controllers\Controller;
use App\Models\Master_Barang;
use App\Models\Master_Jaritan;
use App\Models\Penjualan_Jasa_Jarit;
use Illuminate\Http\Request;

class GetUpdatePenjualanJasaJaritController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Int $id)
    {
        try {
            // get data id
            $data = Master_Jaritan::where('id', $id)->first();
            
            // if data empty
            if (!$data) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }
            // return data
            return response()->json([
                'result' => $data
            ], 200);
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
