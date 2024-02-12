<?php

namespace App\Http\Controllers\Aktivitas;

use App\Models\ActivityItem;
use Illuminate\Http\Request;
use App\Models\Pgwr_Activity;
use App\Models\ActivityDetail;
use App\Models\Master_Jaritan;
use App\Models\Pegawai_Rumahan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CreateActivityController extends Controller
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
            //get all request data
            $data = $request->all();

            // get data pegawai_rumahan by id_pgwr_rumahan
            $pegawai_rumahan = Pegawai_Rumahan::find($data['id_pgw_rumahan']);

            // if pegawai_rumahan not found
            if (!$pegawai_rumahan) {
                return response()->json([
                    'message' => 'Error: Pegawai Rumahan tidak ditemukan'
                ], 404);

                return redirect()->back()->with(
                    'pesan', 'Error: Pegawai Rumahan tidak ditemukan'
                );
            }

            // validate data
            $validator = Validator::make($data, [
                'id_pgw_rumahan' => 'required|exists:pegawai_rumahan,id',
                // 'activity.*.tanggal' => 'required|date',
                'activity.*.detail.*.id_mstr_jaritan' => 'required|exists:master_jaritan,id',
                'activity.*.detail.*.jumlah_jaritan' => 'required|numeric',
            ]);

            // if validation fails
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error: ' . $validator->errors()
                ], 500);

                return redirect()->back()->with(
                    'pesan', 'Error: ' . $validator->errors()
                );
            }

            // KURANG PERHITUNGAN TOTAL-TOTAL //
            // calculate gaji_bulanan
            $gaji_bulanan = 0;
            foreach ($data['activity'] as $activity) {
                foreach ($activity['detail'] as $detail) {
                    $jaritan = Master_Jaritan::find($detail['id_mstr_jaritan']);
                    $gaji_bulanan += $jaritan->harga * $detail['jumlah_jaritan'];
                }
            }   
            //
            // BUAT DI ATAS INI //

            // *** --- create pgwr_activity --- *** //
            $pgwr_activity = Pgwr_Activity::create([
                'id_pgw_rumahan' => $data['id_pgw_rumahan'],
                // 'gaji_bulanan' => $gaji_bulanan,
            ]);

            // *** --- create activity --- *** //
            foreach ($data['activity'] as $activity) {
                $activity['id_pgwr_activity'] = $pgwr_activity->id;
                $activity_detail = ActivityDetail::create($activity);

                // *** --- create activity_items --- *** //
                foreach ($activity['activity_items'] as $activity_item) {
                    $activity_item['id_activity_detail'] = $activity_detail->id;
                    ActivityItem::create($activity_item);
                }
            }

            // if fails
            if (!$pgwr_activity) {
                return response()->json([
                    'message' => 'Error: Gagal membuat aktivitas'
                ], 500);

                return redirect()->back()->with(
                    'pesan', 'Error: Gagal membuat aktivitas'
                );
            }

            return response()->json([
                'message' => 'Berhasil membuat aktivitas',
                'data' => $pgwr_activity
            ], 200);

            return redirect()->back()->with(
                'success', 'Berhasil membuat aktivitas'
            );

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);

            return redirect()->back()->with(
                'pesan', 'Error: ' . $e->getMessage()

            );
        }
    }
}
