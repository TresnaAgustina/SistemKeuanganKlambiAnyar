<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
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
            // get all request data
            $data = $request->all();

            // validate request data
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $user = User::where('username', $data['username'])->first();

            // attempt to login
            if (!$user) {
                return response()->json([
                    'message' => 'Invalid credentials',
                ], 401);

                // return for monolith app
                // return redirect()->route('login')->with(
                //     'error', 'Invalid credentials'
                // );
            }

            // user data

            // generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            // return token
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);

            // return for monolith app
            // return redirect()->route('dashboard')->with(
            //     'success', 'Login success'
            // );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Login Error: '. $e->getMessage(),
            ], 500);

            // return for monolith app
            // return redirect()->route('login')->with(
            //     'error', 'Login Error: '. $e->getMessage()
            // );
        }
    }
}
