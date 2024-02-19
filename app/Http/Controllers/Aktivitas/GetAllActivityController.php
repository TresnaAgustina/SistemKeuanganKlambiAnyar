<?php

namespace App\Http\Controllers\Aktivitas;

use Illuminate\Http\Request;
use App\Models\Pgwr_Activity;
use App\Http\Controllers\Controller;

class GetAllActivityController extends Controller
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
            // get all  data from pgwr_activities with its relation(activity_detail and activity_item)
            $data = Pgwr_Activity::with('activity_details', 'activity_details.activity_items')->get();

            return view(
                'aktivitas.index', compact('data')
            );
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'pesan', 'Error: '. $e->getMessage()
            );
        }
    }
}
