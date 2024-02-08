<?php

namespace App\Http\Controllers\Penjualan_Jasa_Jarit;

use App\Http\Controllers\Controller;
use App\Models\Master_Barang;
use App\Models\Master_Customer;
use App\Models\Master_Jaritan;
use App\Models\Penjualan_Jasa_Jarit;
use Illuminate\Http\Request;

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
            // get all data from table
            $penjualan_jasa_jarit = Penjualan_Jasa_Jarit::with('cart_penjualan_jasa')->get();
            $data = Penjualan_Jasa_Jarit::all();
            $customer = Master_Customer::all();
            $barang = Master_Barang::all();
            $jaritan = Master_Jaritan::all();

            return view('penjualan.penjualan-jasa.index')->with([
                'data' => $data,
                'pelanggan' => $customer,
                'barang' => $barang,
                'test' => $penjualan_jasa_jarit,
                'jaritan' => $jaritan
            ]);
            // return response
            // return response()->json([
            //     'status' => 'success',
            //     'data' => $penjualan_jasa_jarit
            // ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'pesan' => $e->getMessage()
            ], 500);
            return back()->with('pesan', $e->getMessage());

        }

    }
}
