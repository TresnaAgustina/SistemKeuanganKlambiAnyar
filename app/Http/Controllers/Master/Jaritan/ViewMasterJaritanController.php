<?php

namespace App\Http\Controllers\Master\Jaritan;

use App\Http\Controllers\Controller;
use App\Models\Master_Jaritan;
use Illuminate\Http\Request;

class ViewMasterJaritanController extends Controller
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
            //get data from database
            $data = Master_Jaritan::all();

            //return data
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);

            // for monolith app
            // return view('Master.Jaritan', compact('data'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get data from database',
                'error' => $e->getMessage()
            ], 500);

            // for monolith app
            // return view('dashboard')->with(
            //     'error', 'Failed to get data from database'
            // );
        }
    }
}
