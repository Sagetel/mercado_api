<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    public function user()
    {
        return response()->json(auth('api')->user());
    }
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function update(Request $request)
{
    $user = auth('api')->user();
    $userData = $request->data;
    $allowedFields = ['name', 'surname', 'phone', 'email', 'email_verified_at', 'password', 'birthday', 'ip_address', 'last_login_at'];
    
    foreach ($userData as $key => $value) {
        if (in_array($key, $allowedFields)) {
            if ($key === 'password') {
                $user->$key = Hash::make($value); // Хэшируем пароль
            } else {
                $user->$key = $value;
            }
        }
    }
    
    $user->save();
    
    return response()->json(['message' => 'User data updated successfully']);
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
