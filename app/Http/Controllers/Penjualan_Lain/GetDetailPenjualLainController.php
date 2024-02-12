<?php

namespace App\Http\Controllers\Penjualan_Lain;

use App\Http\Controllers\Controller;
use App\Models\CartPenjualanLain;
use App\Models\Penjualan_Lain;
use Illuminate\Http\Request;

class GetDetailPenjualLainController extends Controller
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
            $data = Penjualan_Lain::where('kode_penjualan', $kode)->first();
            $id = $data->id;
            $metode =  $data->metode_pembayaran;

            $penjualan = CartPenjualanLain::where('id_penjualan_lain', $id)->get();
            
            if($data->metode_pembayaran == "credit"){
                $total = $data->cart_penjualan_lain->sum('subtotal');
            }else{
                $total = 0;
            }
            
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

            return view('penjualan.penjualan-lain.detail')->with([
                'data' => $data,
                'penjualan' => $penjualan,
                'credit' => $total
            ]);

        //    dd($total);
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
