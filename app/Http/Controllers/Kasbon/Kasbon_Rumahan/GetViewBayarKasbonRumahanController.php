<?php

namespace App\Http\Controllers\Kasbon\Kasbon_Rumahan;

use App\Http\Controllers\Controller;
use App\Models\Kasbon_Pegawai;
use Illuminate\Http\Request;

class GetViewBayarKasbonRumahanController extends Controller
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
            // get data from database
            $data = Kasbon_Pegawai::where('id', $id)->first();

            // // return json response
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Success fetch all data',
            //     'data' => $data
            // ], 200);

            // for monolith app
            return view('kasbon.kasbon-rumahan.bayar')->with([
                'data' => $data
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
