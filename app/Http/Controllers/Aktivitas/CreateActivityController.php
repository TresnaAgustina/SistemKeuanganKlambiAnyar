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
            $pegawai_rumahan = Pegawai_Rumahan::where('nip', $data['nip'])->first();
            $id_pegawai = $pegawai_rumahan->id;
            
            // if pegawai_rumahan not found
            if (!$pegawai_rumahan) {
                return redirect()->to('/aktivitas/all')->with(
                    'pesan', 'Error: Pegawai Rumahan tidak ditemukan'
                );
            }

            // validate data
            $validator = Validator::make($data, [
                'activity.*.tanggal' => 'required|date',
                'activity.*.detail.*.id_mstr_jaritan' => 'required|exists:master_jaritan,id',
                'activity.*.detail.*.jumlah_barang' => 'required',
                'activity.*.detail.*.harga_satuan' => 'required',
                'activity.*.detail.*.subtotal' => 'required',
            ]);

            // if validation fails
            if ($validator->fails()) {
                return redirect()->to('/aktivitas/all')->with(
                    'pesan', 'Error: ' . $validator->errors()
                );
            }
        
            // ---***--- PERHITUNGAN TOTAL-TOTAL ---***--- //
            // hitung gaji_harian dari activity_detail
            $gaji_harian = 0;
            foreach ($data['activity'] as $activity) {
                foreach ($activity['detail'] as $activity_item) {

                    if (!empty($activity_item['subtotal'])) {
                        $subtotal = str_replace(['.', ','], '', $activity_item['subtotal']);
                    } else {
                        $subtotal = 0;
                    } 

                    $gaji_harian += $subtotal;

                }
            }

            // tambahkan gaji_harian dengan gaji yang sudah ada pada activity_detail untuk mendapat gaji_bulanan
            $pgwr_activity = Pgwr_Activity::where('id_pgw_rumahan', $id_pegawai)->first();
            if ($pgwr_activity) {
                $gaji_bulanan = $pgwr_activity->gaji_bulanan + $gaji_harian;
            }else{
                $gaji_bulanan = $gaji_harian;
            }
            // BUAT DI ATAS INI //

            // jika data pgwr_activity dengan id_pgw_rumahan sudah ada, maka update data pgwr_activity namun untuk data activity_detail dan activity_items tetap di create
            $pgwr_activity = Pgwr_Activity::where('id_pgw_rumahan', $id_pegawai)->first();
            if ($pgwr_activity) {
                // *** --- update pgwr_activity --- *** //
                $pgwr_activity->gaji_bulanan = $gaji_bulanan;
                $pgwr_activity->save();
                
                // update data gaji_bulanan in pegawai_rumahan
                $pegawai_rumahan->gaji_bulanan = $gaji_bulanan;
                $pegawai_rumahan->save();
            }else{
                // *** --- create pgwr_activity --- *** //
                $pgwr_activity = Pgwr_Activity::create([
                    'id_pgw_rumahan' => $id_pegawai,
                    'gaji_bulanan' => $gaji_bulanan,
                ]);

                // update data gaji_bulanan in pegawai_rumahan
                $pegawai_rumahan->gaji_bulanan = $gaji_bulanan;
                $pegawai_rumahan->save();
            }
            // // ambil gaji_reset sesuai bulan sekarang
            // $gaji_reset = $gaji_reset->where('bulan', date('m'))->first();

            // // ddd($gaji_reset);
            // // update data gaji_bulanan in pegawai_rumahan
            // $pegawai_rumahan->gaji_bulanan = $gaji_bulanan;
            // $pegawai_rumahan->save();

            // jika data activity_detail dengan id_pgwr_activity dan tanggal yang sama sudah ada pada database, maka update data activity_detail namun untuk data activity_items tetap di create
            $activity_detail = ActivityDetail::where('id_pgwr_activity', $pgwr_activity->id)->where('tanggal', date('Y-m-d', strtotime($data['activity'][0]['tanggal'])))->first();
            if ($activity_detail) {
                // *** --- update activity_detail --- *** //
                $activity_detail->gaji_harian = $gaji_harian + $activity_detail->gaji_harian;
                $activity_detail->save();

                // *** --- create activity_items --- *** //
                foreach ($data['activity'][0]['detail'] as $activity_item) {

                    if (!empty($activity_item['harga_satuan'])) {
                        $harga_satuan = str_replace(['.', ','], '', $activity_item['harga_satuan']);
                    } else {
                        $harga_satuan = 0;
                    }  

                    $activity_item['id_activity_detail'] = $activity_detail->id;
                    $activity_item['id_mstr_jaritan'] = $activity_item['id_mstr_jaritan'];
                    $activity_item['jumlah_jaritan'] = $activity_item['jumlah_barang'];
                    $activity_item['total_bayaran'] = $activity_item['jumlah_barang'] * $harga_satuan;
                    ActivityItem::create($activity_item);
                }
            }else{
                // *** --- create activity --- *** //
                foreach ($data['activity'] as $activity) {
                    $activity['id_pgwr_activity'] = $pgwr_activity->id;
                    $activity['tanggal'] = date('Y-m-d', strtotime($activity['tanggal']));
                    $activity['gaji_harian'] = $gaji_harian;

                    $activity_detail = ActivityDetail::create($activity);

                    // *** --- create activity_items --- *** //
                    foreach ($activity['detail'] as $activity_item) {

                        if (!empty($activity_item['harga_satuan'])) {
                            $satuan = str_replace(['.', ','], '', $activity_item['harga_satuan']);
                        } else {
                            $satuan = 0;
                        }  

                        $activity_item['id_activity_detail'] = $activity_detail->id;
                        $activity_item['id_mstr_jaritan'] = $activity_item['id_mstr_jaritan'];
                        $activity_item['jumlah_jaritan'] = $activity_item['jumlah_barang'];
                        $activity_item['total_bayaran'] = $activity_item['jumlah_barang'] * $satuan;
                        ActivityItem::create($activity_item);
                    }
                }
            }

            // if fails
            if (!$pgwr_activity) {
                return redirect()->to('/aktivitas/all')->with(
                    'pesan', 'Error: Gagal membuat aktivitas'
                );
            }

            return redirect()->to('/aktivitas/all')->with(
                'success', 'Berhasil membuat aktivitas'
            );

        } catch (\Exception $e) {
            return redirect()->to('/aktivitas/all')->with(
                'pesan', 'Error: ' . $e->getMessage()

            );
        }
    }
}
