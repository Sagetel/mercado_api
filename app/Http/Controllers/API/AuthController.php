<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth:api')-> except('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if(! $token = auth('api')-> attempts($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function user()
    {
        return response()->json(auth('api')->users());
    }
    public function logout()
    {

    }
    public function refresh()
    {

    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Config::get('jwt.ttl') * 60
        ]);
    }
}
