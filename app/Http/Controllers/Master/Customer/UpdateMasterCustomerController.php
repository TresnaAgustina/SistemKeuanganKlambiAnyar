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
                // 'nama_customer' => 'required|unique:master_customer,nama_customer',
                'nama_customer' => 'required',
                'alamat_customer' => 'nullable|string',
                // 'no_telp_customer' => 'required|string|size:12|unique:master_customer,no_telp_customer',
                'no_telp_customer' => 'required|string|size:12',
                // 'status_customer' => 'required|in:aktif,tidak aktif',
                'status_customer' => 'required',
            ]);
            // $validate = $request->validate([
            //     // 'nama_customer' => 'required|unique:master_customer,nama_customer',
            //     'nama_customer' => 'required',
            //     'alamat_customer' => 'nullable|string',
            //     // 'no_telp_customer' => 'required|string|size:12|unique:master_customer,no_telp_customer',
            //     'no_telp_customer' => 'required|string|size:12',
            //     // 'status_customer' => 'required|in:aktif,tidak aktif',
            //     'status_customer' => 'required',
            // ]);

            //if validation fails
            if (!$validate) {
                return back()->with(
                    'pesan', 'Error: ' . $request->errors()
                );
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
                return back()->with(
                    'pesan', 'Error: Failed to update data to database'
                );
            }

            //return data
            return back()->with(
                'success', 'Success to update data to database'
            );
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'pesan' => 'Update Data Master Customer Failed!'. $e->getMessage(),
                'data' => ''
            ], 400);
        }
    }
}
