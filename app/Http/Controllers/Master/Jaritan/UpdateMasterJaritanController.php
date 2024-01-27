<?php

namespace App\Http\Controllers\Master\Jaritan;

use Illuminate\Http\Request;
use App\Models\Master_Jaritan;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rules\In;

class UpdateMasterJaritanController extends Controller
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
            // get all request data
            $data = $request->all();

            // // check if data exists in database
            $check = Master_Jaritan::where('id', $id)->first();

            // if data not found
            if (!$check) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }

            // validation
            $validate = $request->validate([
               'jenis' => 'required|unique:master_jaritan,jenis_jaritan',
               'hargaDalam' => 'nullable|numeric',
               'hargaLuar' => 'nullable|numeric',
            ]);

            // if validation fails
            if (!$validate) {
                return back()->with(
                    'pesan', 'Error: ' . $request->errors()
                );
            }

            // update data to database
            $update = Master_Jaritan::where('id', $id)->update([
                'jenis_jaritan' => $data['jenis'],
                'harga_dalam' => $data['hargaDalam'],
                'harga_luar' => $data['hargaLuar'],
            ]);
            // if update data fails
            if (!$update) {
                return back()->with(
                    'pesan', 'Error: Failed to update data to database'
                );
            }

            //return data
            return back()->with(
                'pesan', 'Success to update data to database'
            );
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
