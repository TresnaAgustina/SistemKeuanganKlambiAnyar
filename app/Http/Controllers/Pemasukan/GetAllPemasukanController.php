<?php

namespace App\Http\Controllers\Pemasukan;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Master_Pemasukan;

class GetAllPemasukanController extends Controller
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
            //get all data from database
            $data = Pemasukan::all();
            $mstr_data = Master_Pemasukan::all();
            // get nama_atribut from master_pemasukan
            foreach ($data as $key => $value) {
                foreach ($mstr_data as $key2 => $value2) {
                    if ($value->id_mstr_pemasukan == $value2->id) {
                        $value->nama_atribut = $value2->nama_atribut;
                    }
                }
            }

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully get all pemasukan',
                'data' => $data
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
