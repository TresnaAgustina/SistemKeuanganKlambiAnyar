<?php

namespace App\Http\Controllers\Master\Jaritan;

use Illuminate\Http\Request;
use App\Models\Master_Jaritan;
use App\Http\Controllers\Controller;

class CreateMasterJaritanController extends Controller
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
            $validate = $request->validate([
                'jenis_jaritan' => 'required|unique:master_jaritan,jenis_jaritan',
                'harga_dalam' => 'nullable|numeric',
                'harga_luar' => 'nullable|numeric',
            ]);

            // if validation fails
            if (!$validate) {
                return back()->with(
                    'pesan', 'Error: ' . $request->errors()
                );
            }

            //create data to database
            $create = Master_Jaritan::create([
                'jenis_jaritan' => $data['jenis_jaritan'],
                'harga_dalam' => $data['harga_dalam'],
                'harga_luar' => $data['harga_luar'],
            ]);

            // if create data fails
            if (!$create) {
                return back()->with(
                    'pesan', 'Error: Failed to store data to database'
                );
            }

            //return data
            return back()->with(
                'pesan', 'Success to store data to database'
            );
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
