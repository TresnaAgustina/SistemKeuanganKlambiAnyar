<?php

namespace App\Http\Controllers\Master\Barang;

use Illuminate\Http\Request;
use App\Models\Master_Barang;
use App\Http\Controllers\Controller;

class GetAllMasterBarangController extends Controller
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
            $data = Master_Barang::all();


            // return json response
            // return response()->json([
            //     'success' => true,
            //     'pesan' => 'Get All Data Master Barang',
            //     'data' => $data
            // ], 200);

            return view('Master.barang.index')->with([
                'data' => $data
            ]);

            return view('master.barang.all', compact('data'));
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
