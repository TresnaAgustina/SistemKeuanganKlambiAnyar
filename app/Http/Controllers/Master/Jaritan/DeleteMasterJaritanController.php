<?php

namespace App\Http\Controllers\Master\Jaritan;

use App\Http\Controllers\Controller;
use App\Models\Master_Jaritan;
use Illuminate\Http\Request;

class DeleteMasterJaritanController extends Controller
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
            // get id data
            $jaritan = Master_Jaritan::find($request->id);

            // if data doesn't exists
            if (!$jaritan) {
                // return response()->json([
                //     'status' => 'error',
                //     'message' => 'Data not found',
                //     'data' => Null
                // ], 404);

                // for monolith app
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }

            // delete data from database
            $delete = $jaritan->delete();

            // if delete data fails
            if (!$delete) {
                // return response()->json([
                //     'status' => 'error',
                //     'message' => 'Failed to delete data from database',
                //     'data' => Null
                // ], 500);

                // for monolith app
                return back()->with(
                    'pesan', 'Error: Failed to delete data from database'
                );
            }

            // return data
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Success to delete data from database',
            //     'data' => $jaritan
            // ], 200);

            // for monolith app
            return response()->json(['message' => 'berhasil hapus']);
            
        } catch (\Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Failed to delete data from database',
            //     'error' => $e->getMessage()
            // ], 500);

            // for monolith app
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
