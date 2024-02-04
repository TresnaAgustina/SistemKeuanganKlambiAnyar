<?php

namespace App\Http\Controllers\Master\Pegawai\Pegawai_Tetap;

use App\Http\Controllers\Controller;
use App\Models\Pegawai_Normal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdatePgwrTetapController extends Controller
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
            $data = $request->all();

            $getPgw = Pegawai_Normal::findOrfail($id);  

            // ddd($data, $request->all(), $id, $getPgw, $getPgw->id);
            
            // if data not found
            if (!$getPgw) {
                return redirect()->back()->with('pesan', 'Error: Data pegawai tidak tersedia');
            }
    
            // validate request data
            $validate = Validator::make($request->all(), [
                'nama' => 'required|string',
                'alamat' => 'nullable|string',
                'no_telp' => 'required|size:12',
                'jenis_kelamin' => 'required|in:Perempuan,Laki-laki',
                'gaji_pokok' => 'required|numeric',
                'status' => 'required|in:active,inactive'
            ]);

            // ddd($request->all());
    
            // if validation fails
            if ($validate->fails()) {
                // get validaiton error
                $errors = $validate->errors();
                return redirect()->back()->with('pesan', 'Error: ' . $errors->first());

            }
    
            // update data
            $update = $getPgw->update($request->all());
    
            // if update fails
            if (!$update) {
                return redirect()->back()->with('pesan', 'Error: Gagal update data pegawai');
            }

            // return success
            return redirect()->back()->with('success', 'Success: Berhasil update data Pegawai');
        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', 'Error: ' . $e->getMessage());
        }
    }
}
