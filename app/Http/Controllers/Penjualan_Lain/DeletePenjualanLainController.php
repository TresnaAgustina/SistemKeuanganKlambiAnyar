<?php

namespace App\Http\Controllers\Penjualan_Lain;

use Illuminate\Http\Request;
use App\Models\Penjualan_Lain;
use App\Http\Controllers\Controller;

class DeletePenjualanLainController extends Controller
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
            //get data penjualan lain by id
            $penjualan_lain = Penjualan_Lain::find($request->id);

            // if not found, return error
            if (!$penjualan_lain) {
                return redirect()->back()->with('pesan', 'Data penjualan lain tidak ditemukan');
            }

            // delete penjualan lain and the related items in cart penjualan lain
            $penjualan_lain->delete();
            $penjualan_lain->cart_penjualan_lain()->delete();

            return redirect()->back()->with('pesan', 'Data penjualan lain berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', 'Error: ' . $e->getMessage());
        }
    }
}
