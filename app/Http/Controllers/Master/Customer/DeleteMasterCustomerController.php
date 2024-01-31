<?php

namespace App\Http\Controllers\Master\Customer;

use App\Http\Controllers\Controller;
use App\Models\Master_Customer;
use Illuminate\Http\Request;

class DeleteMasterCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Int $id)
    {
        try {
            //get data by id
            $data = Master_Customer::where('id', $id)->first();

            //if data not found
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Data Master Customer Not Found!',
                    'data' => ''
                ], 400);
            }

            //delete data from database
            $delete = Master_Customer::where('id', $id)->delete();

            //if delete data fails
            if (!$delete) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Delete Data Master Customer Failed!',
                    'data' => ''
                ], 400);
            }

            //return json response
            return response()->json([
                'success' => true,
                'message' => 'Delete Data Master Customer Success',
                'data' => $delete
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Delete Data Master Customer Failed!' . $e->getMessage(),
                'data' => ''
            ], 400);
        }
    }
}
