<?php

namespace App\Http\Controllers\Master\Pegawai\Pegawai_Tetap;

use App\Http\Controllers\Controller;
use App\Models\Pegawai_Normal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreatePgwrTetapController extends Controller
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
            // get all data from request
            $data = $request->all();

            // validate
            $validate = Validator::make($data, [
                'nama' => 'required|unique:Pegawai_Normal, nama',
                'alamat' => 'nullable|string',
                'no_telp' => 'required|string|size:12',
                'jenis_kelamin' => 'required|in:1,2',
                'gaji_pokok' => 'required|double',
                'status' => 'required|in:1,2'
            ]);

            // if validation fails
            if (!$validate) {
                return redirect()->back()->with('pesan', 'Error: Gagal membuat data, cek data input');
            }

            // create nip pegawai
            $nip = 'PWT - ' . rand(1, 1000);

            // create data
            $store = Pegawai_Normal::create([
                'nama' => $data['nama'],
                'nip' => $nip,
                'alamat' => $data['alamat'],
                'no_telp' => $data['no_telp'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'gaji_pokok' => $data['gaji_pokok'],
                'status' => $data['status'],
            ]);

            // if store fails
            if (!$store) {
                return redirect()->back()->with('pesan', 'Error: Gagal meyimpan data');
            }

            // return success
            return redirect()->back()->with('success', 'Success: Berhasil menambahkan data Pegawai');
        } catch (\Exception $e) {
            return redirect()->back()->with('pesan', 'Error: '. $e->getMessage());
        }
    }
}
