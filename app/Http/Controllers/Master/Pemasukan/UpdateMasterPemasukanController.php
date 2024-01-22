<?php

namespace App\Http\Controllers\Master\Pemasukan;

use Illuminate\Http\Request;
use App\Models\Master_Pemasukan;
use App\Http\Controllers\Controller;

class UpdateMasterPemasukanController extends Controller
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
            //get all request
            $data = $request->all();

            // find data by id
            $find = Master_Pemasukan::where('id', $request->id)->first();

            // if data not found
            if (!$find) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found',
                    'data' => Null
                ], 404);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Data not found'
                // );
            }

            // validation
            $validate = $request->validate([
                'nama_atribut' => 'string|max:150|unique:master_pemasukan,nama_atribut',
            ]);

            // if validation fails
            if (!$validate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed update data',
                    'data' => $find,
                    'data 2' => $data,
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Failed update data'
                // );
            }

            // update data
            $update = Master_Pemasukan::where('id', $request->id)->update([
                'nama_atribut' => $data['nama_atribut'],
            ]);

            // if update data fails
            if (!$update) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed update data',
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Failed update data'
                // );
            }

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Success update data',
                'data' => [
                    'id' => $request->id,
                    'nama_atribut' => $data['nama_atribut'],
                ]
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Success update data'
            // );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed update data',
                'data' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);

            // for monolith app
            // return redirect()->back()->with(
            //     'error', $e->getMessage()
            // );
        }
    }
}
