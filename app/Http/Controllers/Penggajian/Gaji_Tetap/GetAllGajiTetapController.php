<?php

namespace App\Http\Controllers\Penggajian\Gaji_Tetap;

use App\Http\Controllers\Controller;
use App\Models\Pegawai_Normal;
use App\Models\Pegawai_Rumahan;
use Illuminate\Http\Request;

class GetAllGajiTetapController extends Controller
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
            // get data from database
            $data = Pegawai_Normal::all();

            $gaji = $data->sum('gaji_final');

            // // return json response
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Success fetch all data',
            //     'data' => $data
            // ], 200);

            // for monolith app
            return view('penggajian.gaji-tetap.index')->with([
                'data' => $data,
                'gaji' => $gaji
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed fetch all data',
                'data' => $e->getMessage()
            ], 500);

            // for monolith app
            // return view('dasboard')->with(
            //     'error', $e->getMessage()
            // );
        }
    }
}
