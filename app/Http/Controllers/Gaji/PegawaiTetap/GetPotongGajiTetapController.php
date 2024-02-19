<?php

namespace App\Http\Controllers\Gaji\PegawaiTetap;

use Illuminate\Http\Request;
use App\Models\KasbonPgwTetap;
use App\Http\Controllers\Controller;

class GetPotongGajiTetapController extends Controller
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
            // get data kasbon_pgw_tetap with pegawai_normal according to the id
            $data = KasbonPgwTetap::where('id', $request->id)->with('pegawai_normal')->get();

            // if data not found
            if (!$data) {
                return response()->json([
                    'message' => 'data not found',
                    'data' => null
                ], 404);
            }

            // return sucess response
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
