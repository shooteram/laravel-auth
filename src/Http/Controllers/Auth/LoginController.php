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

    public function username()
    {
        return config('cors.auth.login.username', 'email');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(array_keys(config('cors.validation.login')));
        $validator = Validator::make($credentials, config('cors.validation.login'));

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        $user = Auth::attempt($credentials);

        return $user
            ? response()->json(['token' => $user->createToken('Password grant')->accessToken], 200)
            : response()->json(['error' => 'These credentials do not match our records.'], 400);
    }

    public function display()
    {
        return response()->json(['message' => 'Send a POST request to this route to log in.']);
    }
}
