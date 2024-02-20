<?php

namespace App\Http\Controllers\Gaji\PegawaiRumahan;

use App\Http\Controllers\Controller;
use App\Models\KasbonPgwRumahan;
use App\Models\Pegawai_Rumahan;
use Illuminate\Http\Request;

class GetPotongGajiRumahanController extends Controller
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
            $pegawai = Pegawai_Rumahan::where('id', $request->id)->first();
            $data = $pegawai->kasbon_pegawai_rumahan;

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
                return redirect()->to('/gaji/pegawai-rumahan/all')->with(
                    'pesan' , 'Pegawai Tidak Memiliki Kasbon'
                );
            }

            if($pegawai){

                if(isset($pegawai->gaji_bulanan)){
                    $gaji = $pegawai->gaji_bulanan;
                }else{
                    $gaji = 0;
                }
            }else{  
                return redirect()->to('/gaji/pegawai-rumahan/all')->with(
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
            return view('penggajian.gaji-rumahan.bayar')->with([
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
