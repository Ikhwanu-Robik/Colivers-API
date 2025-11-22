<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class Util
{
     public static function setupDatabase()
    {
        Artisan::call('migrate');
    }

    public static function createUser()
    {
        $phone = '0812-6578-9189';
        $password = '12345678';
        $user = User::factory()->create(['phone' => $phone, 'password' => $password]);
        $user->passwordPlain = $password;
        return $user;
    }
}