<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $this->extractCredentials($request);
        $isLoggedIn = Auth::attempt($credentials);

        if ($isLoggedIn) {
            $user = Auth::user();
            $token = $this->createUserToken($user);
            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'The credentials do not match our record'], 401);
    }

    private function extractCredentials(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        $credentials = [
            'phone' => $phone,
            'password' => $password
        ];
        return $credentials;
    }

    private function createUserToken($user)
    {
        $token = $user->createToken(User::class);
        return $token->plainTextToken;
    }
}
