<?php

namespace App\Http\Controllers\Penjualan_Lain;

use App\Http\Controllers\Controller;
use App\Models\Master_Barang;
use App\Models\Master_Customer;
use App\Models\Penjualan_Lain;
use Illuminate\Http\Request;

class GetAllPenjualanLainController extends Controller
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
            $data = Penjualan_Lain::all();
             //get all data from Penjualan_Lain and CartPenjualanLain
             $penjualan_lain = Penjualan_Lain::with('cart_penjualan_lain')->get();
             $customer = Master_Customer::all();
            $barang = Master_Barang::all();

            // // return response
            // return response()->json([
            //     'status' => 'success',
            //     'data' => $penjualan_lain
            // ], 200);

            return view('penjualan.penjualan-lain.index')->with([
                'data' => $data,
                'test' => $penjualan_lain,
                'pelanggan' => $customer,
                'barang' => $barang,

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'pesan' => $e->getMessage()
            ], 500);
            return back()->with('pesan', $e->getMessage());
        }
    }
}
