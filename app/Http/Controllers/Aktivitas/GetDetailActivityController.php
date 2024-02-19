<?php

namespace App\Http\Controllers\Aktivitas;

use Illuminate\Http\Request;
use App\Models\Pgwr_Activity;
use App\Http\Controllers\Controller;

class GetDetailActivityController extends Controller
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
            // get data from pgwr_activities with its relation(activity_detail and activity_item) by id
            $data = Pgwr_Activity::where('id', $request->id)->with('activity_details', 'activity_details.activity_items')->first();

            if (!$data) {
                return redirect()->back()->with(
                    'pesan', 'Data not found'
                );
            }

            return view(
                'aktivitas.detail', compact('data')
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: '. $e->getMessage()
            ], 500);
            return redirect()->back()->with(
                'pesan', 'Error: '. $e->getMessage()
            );
        }
    }
}
