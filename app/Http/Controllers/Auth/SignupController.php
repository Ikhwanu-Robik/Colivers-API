<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;

class SignupController extends Controller
{
    public function __invoke(SignupRequest $request)
    {
        $attributes = $request->validated();
        $user = User::create($attributes);
        return response()->json(['user' => $user]);
    }
}
