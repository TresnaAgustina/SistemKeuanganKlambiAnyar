<?php

namespace App\Http\Controllers\Master\Pemasukan;

use Illuminate\Http\Request;
use App\Models\Master_Pemasukan;
use App\Http\Controllers\Controller;

class UpdateMasterPemasukanController extends Controller
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
            $check = Master_Pemasukan::where('id', $id)->first();

            // if data not found
            if (!$check) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }

            // validation
            $validate = $request->validate([
               'nama_atribut' => 'required'
            ]);

            // if validation fails
            if (!$validate) {
                return back()->with(
                    'pesan', 'Error: ' . $request->errors()
                );
            }

            // update data to database
            $update = Master_Pemasukan::where('id', $id)->update([
                'nama_atribut' => $data['nama_atribut']
            ]);
            // if update data fails
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
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
