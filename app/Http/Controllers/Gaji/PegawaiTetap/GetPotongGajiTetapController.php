<?php

namespace App\Http\Controllers\Gaji\PegawaiTetap;

use Illuminate\Http\Request;
use App\Models\KasbonPgwTetap;
use App\Http\Controllers\Controller;
use App\Models\Pegawai_Normal;

class GetPotongGajiTetapController extends Controller
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
            // get data kasbon_pgw_tetap with pegawai_normal according to the id

            $pegawai = Pegawai_Normal::where('id', $request->id)->first();
            $data = $pegawai->kasbon_pegawai_tetap;

            // $kasbon = $data->pegawai_normal->jumlah_kasbon;

            if($data){

                if(isset($data->jumlah_kasbon)){
                    $kasbon = $data->jumlah_kasbon;
                }else{
                    $kasbon = 0;
                }

                if(isset($data->sisa)){
                    $sisa = $data->sisa;
                }else{
                    $sisa = 0;
                }
            }else{
                return redirect()->to('/gaji/pegawai-tetap/all')->with(
                    'pesan' , 'Pegawai Tidak Memiliki Kasbon'
                );
            }

            if($pegawai){

                if(isset($pegawai->gaji_pokok)){
                    $gaji = $pegawai->gaji_pokok;
                }else{
                    $gaji = 0;
                }
            }else{
                return redirect()->to('/gaji/pegawai-tetap/all')->with(
                    'pesan' , 'Pegawai Tidak Memiliki Gaji'
                );
            }

          

            // if data not found
            // if (!$data) {
            //     return response()->json([
            //         'message' => 'data not found',
            //         'data' => null
            //     ], 404);
            // }

            // return sucess response
            // return response()->json([
            //     'message' => 'success',
            //     'data' => $data
            // ], 200);

            return view('penggajian.gaji-tetap.bayar')->with([
                'data' => $data,
                'kasbon' => $kasbon,
                'sisa' => $sisa,
                'gaji' => $gaji
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
