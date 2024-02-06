<?php

namespace App\Http\Controllers\Penjualan_Jasa_Jarit;

use App\Http\Controllers\Controller;
use App\Models\Master_Barang;
use App\Models\Master_Customer;
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
            $data = Penjualan_Jasa_Jarit::all();
            $customer = Master_Customer::all();
            $barang = Master_Barang::all();

            return view('penjualan.penjualan-jasa.index')->with([
                'data' => $data,
                'pelanggan' => $customer,
                'barang' => $barang
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Get All Data Master Barang Failed!'. $e->getMessage(),
                'data' => ''
            ], 400);

            return back()->with('pesan', $e->getMessage());
        }
    }
}
