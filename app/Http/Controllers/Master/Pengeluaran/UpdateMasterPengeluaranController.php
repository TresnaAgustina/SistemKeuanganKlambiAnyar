<?php

namespace App\Http\Controllers\Master\Pengeluaran;

use App\Http\Controllers\Controller;
use App\Models\Master_Pengeluaran;
use Illuminate\Http\Request;

class UpdateMasterPengeluaranController extends Controller
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
            $check = Master_Pengeluaran::where('id', $id)->first();

            // if data not found
            if (!$check) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }

            // validation
            $validate = $request->validate([
                'nama_atribut' => 'required',
                'tipe' => 'required',
            ]);

            // if validation fails
            if (!$validate) {
                return back()->with(
                    'pesan', 'Error: ' . $request->errors()
                );
            }

            // update data to database
            $update = Master_Pengeluaran::where('id', $id)->update([
                'nama_atribut' => $data['nama_atribut'],
                'tipe' => $data['tipe'],
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
