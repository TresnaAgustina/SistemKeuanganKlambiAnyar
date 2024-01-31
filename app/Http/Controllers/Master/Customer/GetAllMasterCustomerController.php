<?php

namespace App\Http\Controllers\Master\Customer;

use Illuminate\Http\Request;
use App\Models\Master_Customer;
use App\Http\Controllers\Controller;

class GetAllMasterCustomerController extends Controller
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
            // Get all data from database
            $data = Master_Customer::all();

            // return json response
            return response()->json([
                'success' => true,
                'pesan' => 'Get All Data Master Customer Success',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Get All Data Master Customer Failed!'. $e->getMessage(),
                'data' => ''
            ], 400);
        }
    }
}
