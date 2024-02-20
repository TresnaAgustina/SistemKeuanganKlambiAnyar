<?php

namespace App\Http\Controllers\Gaji\PegawaiTetap;

use Illuminate\Http\Request;
use App\Models\KasbonPgwTetap;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PotongGajiTetapController extends Controller
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

            // validation
            $validate = Validator::make($data, [
                'id_kasbon_tetap' => 'required|numeric',
                'jumlah_potong' => 'nullable',
                'jumlah_beri' => 'nullable'
            ]);

            if (!empty($data['jumlah_potong'])) {
                $jumlah_potong = str_replace(['.'], '', $data['jumlah_potong']);
            } else {
                $jumlah_potong = null;
            }

            if (!empty($data['jumlah_beri'])) {
                $jumlah_beri = str_replace(['.'], '', $data['jumlah_beri']);
            } else {
                $jumlah_beri = null;
            }

            // if validation fails
            if (!$validate) {
                // return response()->json([
                //     'message' => 'validation failed',
                //     'error' => $validate->errors()
                // ], 422);

                return redirect()->to('/gaji/pegawai-tetap/all')->with(
                    'pesan' , $validate->errors()
            );
            }

            // jika data jumlah_potong dan jumlah_beri kosong, atau data jumlah_potong dan jumlah_beri tidak kosong, maka return error
            if (($data['jumlah_potong'] == null && $data['jumlah_beri'] == null) || ($data['jumlah_potong'] != null && $data['jumlah_beri'] != null)) {
                // return response()->json([
                //     'message' => 'failed',
                //     'error' => 'Gagal memproses data, cek data inputan anda'
                // ], 422);

                return redirect()->to('/gaji/pegawai-tetap/all')->with(
                    'pesan' , 'Gagal memproses data, cek data inputan anda'
                );
            }

            // get data kasbon_pgw_tetap with pegawai_normal according to the id
            $kasbon = KasbonPgwTetap::where('id', $data['id_kasbon_tetap'])->with('pegawai_normal')->first();

            // jika nilai jumlah_potong tidak kosong, maka update data kasbon_pgw_tetap -> sisa, status
            if ($data['jumlah_potong'] != null) {
                // calculate gaji_final
                $gaji_final = $kasbon->pegawai_normal->gaji_pokok - $jumlah_potong;

                // jika gaji_pokok dari pegawai_normal lebih sedikit dari jumlah_potong, maka return error
                if ($kasbon->pegawai_normal->gaji_pokok < $jumlah_potong) {
                    // return response()->json([
                    //     'message' => 'failed',
                    //     'error' => 'Gaji pokok tidak cukup untuk melakukan potongan'
                    // ], 422);

                    
                    return redirect()->to('/gaji/pegawai-tetap/all')->with(
                        'pesan' , 'Gaji pokok tidak cukup untuk melakukan potongan'
                    );
                }

                $potong = $kasbon->update([
                    'sisa' => $kasbon->sisa - $jumlah_potong,
                    'status' => $kasbon->sisa - $jumlah_potong == 0 ? 'lunas' : 'belum lunas'
                ]);

                // jika kasbon sudah lunas, maka kembalikan gaji_final ke gaji_pokok
                if ($kasbon->status == 'lunas') {
                    $gaji_final = $kasbon->pegawai_normal->gaji_pokok;
                }
            }else{
                // calculate gaji_final
                $gaji_final = $kasbon->pegawai_normal->gaji_pokok + $jumlah_beri;

                // jika data jumlah_potong kosong dan data jumlah_beri tidak kosong, maka update data kasbon_pgw_tetap -> sisa, status
                $potong = $kasbon->update([
                    'sisa' => $kasbon->sisa + $jumlah_beri,
                    'status' => $kasbon->sisa + $jumlah_beri == 0 ? 'lunas' : 'belum lunas'
                ]);
            }

            // update data pegawai_normal -> gaji_final ($gaji_final)
            $potong = $kasbon->pegawai_normal->update([
                'gaji_final' => $gaji_final
            ]);

            // if update fails
            if (!$potong) {
                // return response()->json([
                //     'message' => 'failed',
                //     'error' => 'Gagal memproses data, cek data inputan anda'
                // ], 500);

                
            return redirect()->to('/gaji/pegawai-tetap/all')->with(
                'pesan' , 'Gagal memproses data, cek data inputan anda'
            );
            }

            // return success response
            // return response()->json([
            //     'message' => 'success',
            //     'data' => $kasbon
            // ], 200);

            return redirect()->to('/gaji/pegawai-tetap/all')->with(
                'success', 'Success Potong Gaji'
            );

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
