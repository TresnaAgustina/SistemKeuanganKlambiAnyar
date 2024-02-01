<?php

namespace App\Http\Controllers\Master\Pegawai\Pegawai_Rumahan;

use App\Http\Controllers\Controller;
use App\Models\Pegawai_Rumahan;
use Illuminate\Http\Request;

class UpdatePgwrRumahanController extends Controller
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
            //get all data from request
            $data = $request->all();

            // get data by id
            $pegawai = Pegawai_Rumahan::where('id', $id);
            $nip = $pegawai->nip;

            // if data not found
            if (!$pegawai) {
                return redirect()->back()->with('pesan', 'Error: Data pegawai tidak tersedia');
            }

            // validate data
            $validate = Validator::make($data, [
                'nama' => 'required|string|unique: Pegawai_Normal, nama',
                'alamat' => 'nullable|string',
                'no_telp' => 'required|size:12',
                'jenis_kelamin' => 'required|in:1,2',
                'status' => 'required|in:1,2'
            ]);

            // if validation fails
            if (!$validate) {
                return redirect()->back()->with('pesan', 'Error: Gagal update data pegawai, cek data input');
            }

            // update data
            $update = Pegawai_Rumahan::where('id', $id)->update([
                'nama' => $data['nama'],
                'nip' => $nip,
                'alamat' => $data['alamat'],
                'no_telp' => $data['no_telp'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'status' => $data['status']
            ]);

            // if update fails
            if (!$update) {
                return redirect()->back()->with('pesan', 'Error: Gagal update data pegawai');
            }

            // return
            return redirect()->back()->with('success', 'Success: Berhasil update data pegawi');
        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', 'Error: ' . $e->getMessage());
        }
    }
}
