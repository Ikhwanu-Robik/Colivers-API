<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class UserAuthenticationTest extends TestCase
{
    private $user;

    public function test_user_can_login_with_correct_credentials(): void
    {
        $this->setupDatabase();
        $this->createUser();

        $response = $this->postJson('/api/login', [
            'phone' => $this->user->phone,
            'password' => $this->user->passwordPlain
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'token'
        ]);
    }

    public function test_user_cannot_login_with_incorrect_credentials(): void
    {
        $this->setupDatabase();
        $this->createUser();
        $otherPhone = '081335356767';
        
        $response = $this->postJson('/api/login', [
            'phone' => $otherPhone,
            'password' => $this->user->password
        ]);

        $response->assertUnauthorized();
    }

    private function setupDatabase()
    {
        Artisan::call('migrate');
    }

    private function createUser()
    {
        $phone = '081265789189';
        $password = '12345678';
        $this->user = User::factory()->create(['phone' => $phone, 'password' => $password]);
        $this->user->passwordPlain = $password;
    }
}
