<?php

namespace App\Http\Controllers\Aktivitas;

use App\Http\Controllers\Controller;
use App\Models\ActivityDetail;
use App\Models\ActivityItem;
use Illuminate\Http\Request;

class GetDetailAktivitasController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        try {
            // get data id
            $data = ActivityDetail::where('id_pgwr_activity', $id)->first();
            $id_activity = $data->id;

            $detail = ActivityItem::where('id_activity_detail', $id_activity)->get();
            
           
            
            // if data empty
            if (!$data) {
                return back()->with(
                    'pesan', 'Error: Data not found'
                );
            }
            // return data
            // return response()->json([
            //     'result' => $data
            // ], 200);

            return view('aktivitas.detail')->with([
                'data' => $data,
                'detail' => $detail,
            ]);

        //    dd($total);
        } catch (\Exception $e) {
            return back()->with(
                'pesan', 'Error: ' . $e->getMessage()
            );
        }
    }
}
