<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;

class SignupController extends Controller
{
    public function __invoke(SignupRequest $request)
    {
        $profilePhotoFile = $request->file('profile_photo');
        $pathToStoredImage = $profilePhotoFile->store('profile_pics', 'public');

        $attributes = $request->validated();
        $attributes['profile_photo'] = $pathToStoredImage;
        $user = User::create($attributes);

        return response()->json([
            'user' => $user,
        ]);
    }
}
