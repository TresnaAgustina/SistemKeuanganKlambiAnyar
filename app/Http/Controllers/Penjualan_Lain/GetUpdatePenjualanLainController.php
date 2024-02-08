<?php

namespace App\Http\Controllers\Penjualan_Lain;

use App\Http\Controllers\Controller;
use App\Models\Master_Barang;
use Illuminate\Http\Request;

class GetUpdatePenjualanLainController extends Controller
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
            $data = Master_Barang::where('id', $id)->first();
            
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
