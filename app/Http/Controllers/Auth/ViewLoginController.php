<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewLoginController extends Controller
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
            return view('sesi.login');
        } catch (\Exception $e) {
            return view('dashboard')->with(
                'error', 'Failed to get data from database'
            );
        }
    }
}
