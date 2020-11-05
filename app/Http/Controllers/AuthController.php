<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Validate attempted user login.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param Request $request
     *
     * @return Json
     */
    public function login(Request $request)
    {
        $passed = false;
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if (Auth::attempt($credentials)) {
            $user->makeVisible('api_token');
            $passed = true;
        }

        return response()->json([
            'passed' => $passed,
            'user' => $user
        ]);
    }

    /**
     * Send a forgot password email.
     * @author Stephen Medd | 28 Oct 2020
     *
     * @param Request $request
     *
     * @return Json
     */
    public function forgot(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        /**
         * There is no account with this email.
         */
        if ($user === null) {
            return response()->json([
                'status' => 'no-account'
            ]);
        }

        $user->sendResetPasswordEmail();

        return response()->json([
            'status' => 'sent'
        ]);
    }
}
