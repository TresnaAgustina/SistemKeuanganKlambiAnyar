<?php

namespace App\Http\Controllers\Gaji\PegawaiRumahan;

use App\Http\Controllers\Controller;
use App\Models\KasbonPgwRumahan;
use App\Models\Pegawai_Rumahan;
use Illuminate\Http\Request;

class GetAllGajiRumahanController extends Controller
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
            // get all data kasbon_pgw_tetap and get the data pegawai_normal from the kasbon_pgw_tetap
            $data = KasbonPgwRumahan::with('pegawai_rumahan')->get();
            $pegawai = Pegawai_Rumahan::all();

            // if data pegawai_normal have kasbon_pgw_tetap, dont return the data
            foreach ($pegawai as $key => $value) {
                foreach ($data as $key2 => $value2) {
                    if ($value->id == $value2->id_pgw_rumahan) {
                        unset($pegawai[$key]);
                    }
                }
            }

            // make the data and pegawai in one variable, and sort the data by id
            $pegawai = $pegawai->merge($data);
            $pegawai = $pegawai->sortBy('id');
            // $pegawai = $pegawai->merge($data);

            // return 2 variable in json response
            return response()->json([
                'message' => 'success',
                'data' => $pegawai
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
