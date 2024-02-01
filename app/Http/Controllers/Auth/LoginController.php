<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            if (!$user || !Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
                return redirect()->route('login')->with('error', 'Invalid credentials');
            }

            // generate token
            $token = $user->createToken('auth_token')->plainTextToken;

            // return json response
            // return response()->json([
            //     'success' => true,
            //     'pesan' => 'Login Success',
            //     'data' => [
            //         'user' => $user,
            //         'token' => $token
            //     ]
            // ], 200);

            return redirect()->route('dashboard')->with('success', 'Login success');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login Error: ' . $e->getMessage());
        }
    }
}
