<?php

namespace shooteram\Auth\Http\Controllers\Auth;

use Auth;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(config('cors.validation.login-credentials'));

        $validator = Validator::make($credentials, config('cors.validation.login'));

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()], 400);

        return Auth::attempt($credentials)
            ? response()->json(Auth::user(), 200)
            : response()->json(['error' => 'These credentials do not match our records.'], 400);
    }
}