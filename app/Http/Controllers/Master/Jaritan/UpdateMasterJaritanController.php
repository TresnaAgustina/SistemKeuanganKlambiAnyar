<?php

namespace App\Http\Controllers\Master\Jaritan;

use Illuminate\Http\Request;
use App\Models\Master_Jaritan;
use App\Http\Controllers\Controller;

class UpdateMasterJaritanController extends Controller
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
            // get all request data
            $data = $request->all();

            // // check if data exists in database
            $check = Master_Jaritan::where('id', $request->id)->first();

            // if data not found
            if (!$check) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data not found',
                    'data' => Null
                ], 404);

                // for monolith app
                // return redirect()->route('jaritan.all')->with(
                //     'error', 'Data not found'
                // );
            }

            // validation
            $validate = $request->validate([
               'jenis_jaritan' => 'required|unique:master_jaritan,jenis_jaritan',
               'harga_dalam' => 'nullable|numeric',
               'harga_luar' => 'nullable|numeric',
            ]);

            // if validation fails
            if (!$validate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: Failed to validate data',
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->route('jaritan.all')->with(
                //     'error', 'Error: ' . $request->errors()
                // );
            }

            // update data to database
            $update = Master_Jaritan::where('id', $request->id)->update([
                'jenis_jaritan' => $data['jenis_jaritan'],
                'harga_dalam' => $data['harga_dalam'],
                'harga_luar' => $data['harga_luar'],
            ]);
            // if update data fails
            if (!$update) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to update data to database',
                    'data' => Null
                ], 500);

                // for monolith app
                // return redirect()->route('jaritan.all')->with(
                //     'error', 'Failed to update data to database'
                // );
            }

            //return data
            return response()->json([
                'status' => 'success',
                'message' => 'Success to update data to database',
                'data' => [
                    'id' => $request->id,
                    'jenis_jaritan' => $data['jenis_jaritan'],
                    'harga_dalam' => $data['harga_dalam'],
                    'harga_luar' => $data['harga_luar'],
                ]
            ], 200);

            // for monolith app
            // return redirect()->route('jaritan.all')->with(
            //     'success', 'Success to update data to database'
            // );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage(),
                'data' => Null
            ], 500);

            // for monolith app
            // return redirect()->route('jaritan.all')->with(
            //     'error', 'Failed to update data to database'
            // );
        }
    }
}
