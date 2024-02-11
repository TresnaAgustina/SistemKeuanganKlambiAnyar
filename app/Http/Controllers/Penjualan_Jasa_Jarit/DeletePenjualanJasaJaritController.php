<?php

namespace App\Http\Controllers\Penjualan_Jasa_Jarit;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Penjualan_Jasa_Jarit;

class DeletePenjualanJasaJaritController extends Controller
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
            //get data penjualan jasa jarit by id
            $penjualan_jasa_jarit = Penjualan_Jasa_Jarit::find($request->id);

            // if not found, return error
            if (!$penjualan_jasa_jarit) {
                return redirect()->back()->with('pesan', 'Data penjualan jasa jarit tidak ditemukan');
            }

            // delete penjualan jasa jarit and the related items in cart penjualan jasa jarit
            $penjualan_jasa_jarit->delete();
            $penjualan_jasa_jarit->cart_penjualan_jasa_jarit()->delete();

            return redirect()->back()->with('pesan', 'Data penjualan jasa jarit berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', 'Error: ' . $e->getMessage());
        }
    }
}
