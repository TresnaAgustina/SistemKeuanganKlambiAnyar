<?php

namespace App\Http\Controllers\Master\Customer;

use Illuminate\Http\Request;
use App\Models\Master_Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UpdateMasterCustomerController extends Controller
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
            // get all data request
            $data = $request->all();

            // get data by id
            $check = Master_Customer::where('id', $id)->first();

            // if data not found
            if (!$check) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Data Master Customer Not Found!',
                    'data' => ''
                ], 400);
            }

            // validation
            $validate = Validator::make($data, [
                'nama_customer' => 'required|unique:master_customer,nama_customer',
                'alamat_customer' => 'nullable|string',
                'no_telp_customer' => 'required|string|size:12|unique:master_customer,no_telp_customer',
                'status_customer' => 'required|in:1,2',
            ]);

            //if validation fails
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Create Data Master Customer Failed!',
                    'data' => $validate->errors()
                ], 400);
            }

            //update data 
            $update = Master_Customer::where('id', $id)->update([
                'nama_customer' => $data['nama_customer'],
                'alamat_customer' => $data['alamat_customer'],
                'no_telp_customer' => $data['no_telp_customer'],
                'status_customer' => $data['status_customer'],
            ]);

            //if update data fails
            if (!$update) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Update Data Master Customer Failed!',
                    'data' => ''
                ], 400);
            }

            //return json response
            return response()->json([
                'success' => true,
                'pesan' => 'Update Data Master Customer Success',
                'data' => $update
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Update Data Master Customer Failed!'. $e->getMessage(),
                'data' => ''
            ], 400);
        }
    }
}
