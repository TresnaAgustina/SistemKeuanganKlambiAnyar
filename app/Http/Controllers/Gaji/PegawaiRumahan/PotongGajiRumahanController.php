<?php

namespace App\Http\Controllers\Gaji\PegawaiRumahan;

use Illuminate\Http\Request;
use App\Models\KasbonPgwRumahan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PotongGajiRumahanController extends Controller
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
            //get all data request
            $data = $request->all();

            // validate the request
            $validate = Validator::make($data, [
                'id_kasbon_rumahan' => 'required|numeric',
                'jumlah_potong' => 'nullable|numeric',
                'jumlah_beri' => 'nullable|numeric'
            ]);

            // if validation fails
            if ($validate->fails()) {
                return response()->json([
                    'message' => 'validation failed',
                    'error' => $validate->errors()
                ], 422);
            }

            // if the data jumlah_potong and jumlah_beri is empty, or the data jumlah_potong and jumlah_beri is not empty, then return error
            if (($data['jumlah_potong'] == null && $data['jumlah_beri'] == null) || ($data['jumlah_potong'] != null && $data['jumlah_beri'] != null)) {
                return response()->json([
                    'message' => 'failed',
                    'error' => 'Gagal memproses data, cek data inputan anda'
                ], 422);
            }

            // get data kasbon_pgw_rumahan with pegawai_rumahan according to the id
            $kasbon = KasbonPgwRumahan::where('id', $data['id_kasbon_rumahan'])->with('pegawai_rumahan')->first();

            // if the value of jumlah_potong is not empty, then update the data kasbon_pgw_rumahan -> sisa, status
            if ($data['jumlah_potong'] != null) {
                // calculate gaji_final
                $gaji_final = $kasbon->pegawai_rumahan->gaji_bulanan - $data['jumlah_potong'];

                // jika gaji_bulanan dari pegawai_rumahan lebih sedikit dari jumlah_potong, maka return error
                if ($kasbon->pegawai_rumahan->gaji_bulanan < $data['jumlah_potong']) {
                    return response()->json([
                        'message' => 'failed',
                        'error' => 'Gaji bulanan tidak cukup untuk melakukan potongan'
                    ], 422);
                }

                $potong = $kasbon->update([
                    'sisa' => $kasbon->sisa - $data['jumlah_potong'],
                    'status' => $kasbon->sisa - $data['jumlah_potong'] == 0 ? 'lunas' : 'belum lunas'
                ]);


                // if kasbon is paid off, then return gaji_final to gaji_pokok
                    $kasbon->pegawai_rumahan->update([
                        'gaji_bulanan' => $gaji_final
                    ]);
            }else{
                // calculate gaji_final
                $gaji_final = $kasbon->pegawai_rumahan->gaji_bulanan + $data['jumlah_beri'];

                // if the data jumlah_potong is empty and the data jumlah_beri is not empty, then update the data kasbon_pgw_rumahan -> sisa, status
                $potong = $kasbon->update([
                    'sisa' => $kasbon->sisa + $data['jumlah_beri'],
                    'status' => 'belum lunas'
                ]);
            }

            // if update fails
            if (!$potong) {
                return response()->json([
                    'message' => 'failed',
                    'error' => 'Gagal memproses data, cek data inputan anda'
                ], 500);
            }

            // return success response
            return response()->json([
                'message' => 'success',
                'data' => $kasbon
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
}
