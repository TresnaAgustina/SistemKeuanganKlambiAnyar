<?php

namespace App\Http\Controllers\Penjualan_Jasa_Jarit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penjualan_Jasa_Jarit;

class GetAllPenjualanJasaJaritController extends Controller
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
            // get all data from Penjualan_Jasa_Jarit and CartPenjualanJasa
            $penjualan_jasa_jarit = Penjualan_Jasa_Jarit::with('cart_penjualan_jasa')->get();

            // return response
            return response()->json([
                'status' => 'success',
                'data' => $penjualan_jasa_jarit
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
