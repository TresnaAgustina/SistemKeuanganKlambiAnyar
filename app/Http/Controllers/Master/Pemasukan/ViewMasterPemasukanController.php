<?php

namespace App\Http\Controllers\Master\Pemasukan;

use App\Http\Controllers\Controller;
use App\Models\Master_Pemasukan;
use Illuminate\Http\Request;

class ViewMasterPemasukanController extends Controller
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
            $data = Master_Pemasukan::all();

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Success fetch all data',
                'data' => $data
            ], 200);

            // for monolith app
            // return view('Master.pemasukan.index', compact('data'));
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
