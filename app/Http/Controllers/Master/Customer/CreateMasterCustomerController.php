<?php

namespace App\Http\Controllers\Master\Customer;

use Illuminate\Http\Request;
use App\Models\Master_Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CreateMasterCustomerController extends Controller
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
            //get all request data
            $data = $request->all();

            // validation
            $validate = Validator::make($data, [
                'nama_customer' => 'required|unique:master_customer,nama_customer',
                'alamat_customer' => 'nullable|string',
                'no_telp_customer' => 'required|string|size:12|unique:master_customer,no_telp_customer',
                'status_customer' => 'required|in:aktif,tidak aktif',
            ]);

            //if validation fails
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'pesan' => 'Create Data Master Customer Failed!',
                    'data' => $validate->errors()
                ], 400);
            }

            //create data to database
            $create = Master_Customer::create([
                'nama_customer' => $data['nama_customer'],
                'alamat_customer' => $data['alamat_customer'],
                'no_telp_customer' => $data['no_telp_customer'],
                'status_customer' => $data['status_customer'],
            ]);

             // if create data fails
             if (!$create) {
                return back()->with(
                    'pesan', 'Error: Failed to store data to database'
                );
            }

            //return data
            return back()->with(
                'success', 'Success to store data to database'
            );

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Create Data Master Customer Failed!'. $e->getMessage(),
                'data' => ''
            ], 400);
        }
    }
}
