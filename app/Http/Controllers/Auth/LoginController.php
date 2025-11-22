<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = $this->extractCredentials($request);
        $user = $this->attemptLogin($credentials);
        $token = $this->createUserToken($user);
        return response()->json(['token' => $token]);
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

    private function attemptLogin(array $credentials)
    {
        $user = User::where('phone', $credentials['phone'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            abort(401, 'The credentials do not match our record');
        }
        return $user;
    }

    private function createUserToken($user)
    {
        $token = $user->createToken(User::class);
        return $token->plainTextToken;
    }
}
