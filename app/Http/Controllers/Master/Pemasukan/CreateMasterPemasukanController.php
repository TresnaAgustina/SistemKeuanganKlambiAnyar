<?php

namespace App\Http\Controllers\Master\Pemasukan;

use Illuminate\Http\Request;
use App\Models\Master_Pemasukan;
use App\Http\Controllers\Controller;

class CreateMasterPemasukanController extends Controller
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
            // get all request
            $data = $request->all();

            // validation
            $validate = $request->validate([
                'nama_atribut' => 'required|string|max:150|unique:master_pemasukan,nama_atribut',
                
            ]);

            // if validation fails
            if (!$validate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed create data',
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Failed create data'
                // );
            }

            // create data
            $create = Master_Pemasukan::create([
                'nama_atribut' => $data['nama_atribut'],
            ]);
            
            // if create data fails
            if (!$create) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed create data',
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Failed create data'
                // );
            }

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Success create data',
                'data' => $create
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Success create data'
            // );

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed create data',
                'data' => $e->getMessage()
            ], 500);

            // for monolith app
            // return redirect()->back()->with(
            //     'error', $e->getMessage()
            // );
        }
    }
}
