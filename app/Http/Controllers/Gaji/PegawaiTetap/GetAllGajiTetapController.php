<?php

namespace App\Http\Controllers\Gaji\PegawaiTetap;

use App\Http\Controllers\Controller;
use App\Models\KasbonPgwTetap;
use App\Models\Pegawai_Normal;
use Illuminate\Http\Request;

class GetAllGajiTetapController extends Controller
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
            $data = KasbonPgwTetap::with('pegawai_normal')->get();
            $pegawai = Pegawai_Normal::all();

            // if data pegawai_normal have kasbon_pgw_tetap, dont return the data
            foreach ($pegawai as $key => $value) {
                foreach ($data as $key2 => $value2) {
                    if ($value->id == $value2->id_pgw_tetap) {
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
