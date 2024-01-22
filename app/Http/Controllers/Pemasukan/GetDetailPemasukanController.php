<?php

namespace App\Http\Controllers\Pemasukan;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Models\Master_Pemasukan;
use App\Http\Controllers\Controller;

class GetDetailPemasukanController extends Controller
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
            //get data by id
            $pemasukan = Pemasukan::findOrFail($request->id);

            // / get nama_atribut from master_pemasukan
            $mstr_data = Master_Pemasukan::all();
            foreach ($mstr_data as $key => $value) {
                if ($pemasukan->id_mstr_pemasukan == $value->id) {
                    $pemasukan->nama_atribut = $value->nama_atribut;
                }
            }

            // if data not found
            if (!$pemasukan) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: Data not found',
                    'data' => Null
                ], 404);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Error: Data not found'
                // );
            }

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Success get data',
                'data' => $pemasukan
            ], 200);

            // for monolith app
            // return view('pemasukan.index', compact('data'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'data' => Null
            ], 500);

            // for monolith app
            // return redirect()->back()->with(
            //     'error', 'Error: ' . $e->getMessage()
            // );
        }
    }
}
