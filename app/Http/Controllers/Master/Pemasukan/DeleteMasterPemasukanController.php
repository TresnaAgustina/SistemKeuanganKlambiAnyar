<?php

namespace App\Http\Controllers\Master\Pemasukan;

use Illuminate\Http\Request;
use App\Models\Master_Pemasukan;
use App\Http\Controllers\Controller;

class DeleteMasterPemasukanController extends Controller
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

            // delete data
            $delete = Master_Pemasukan::where('id', $request->id)->delete();

            // if delete data fails
            if (!$delete) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed delete data',
                    'data' => Null
                ], 400);

                // for monolith app
                // return redirect()->back()->with(
                //     'error', 'Failed delete data'
                // );
            }

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Success delete data',
                'data' => $find
            ], 200);

            // for monolith app
            // return redirect()->back()->with(
            //     'success', 'Success delete data'
            // );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed delete data',
                'data' => $e->getMessage()
            ], 500);

            // for monolith app
            // return redirect()->back()->with(
            //     'error', $e->getMessage()
            // );
        }
    }
}
