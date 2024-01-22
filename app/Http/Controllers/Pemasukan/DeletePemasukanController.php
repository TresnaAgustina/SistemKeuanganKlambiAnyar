<?php

namespace App\Http\Controllers\Pemasukan;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeletePemasukanController extends Controller
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

            // delete data
            $delete = $pemasukan->delete();

            // check if delete is success
            if (!$delete) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error: Failed to delete data',
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Error: Failed to delete data'
                // );
            }

            // return response
            return response()->json([
                'status' => 'success',
                'message' => 'Success delete data',
                'data' => Null
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Success delete data'
            // );
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
