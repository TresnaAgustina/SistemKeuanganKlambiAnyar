<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewLoginController extends Controller
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

            // for monolith app
            return view('sesi.login');

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
