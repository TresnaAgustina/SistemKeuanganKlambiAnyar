<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetAllAktivitasController extends Controller
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
            // // return response
            // return response()->json([
            //     'status' => 'success',
            //     'data' => $penjualan_lain
            // ], 200);

            return view('aktivitas.index');
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'pesan' => $e->getMessage()
            ], 500);
            return back()->with('pesan', $e->getMessage());
        }
    }
}
