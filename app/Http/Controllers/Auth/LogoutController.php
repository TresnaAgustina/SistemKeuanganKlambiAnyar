<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class LogoutController extends Controller
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
            // logout user
            $request->user()->tokens()->delete();

            // return response
            return response()->json([
                'message' => 'Logout success',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout Error: '. $e->getMessage(),
            ], 500);
        }
    }
}
