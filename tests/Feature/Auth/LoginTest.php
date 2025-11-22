<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Tests\Feature\Auth\Util;

class LoginTest extends TestCase
{
    private $user;

    public function test_user_can_login_with_correct_credentials(): void
    {
        Util::setupDatabase();
        $this->user = Util::createUser();

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
        Util::setupDatabase();
        $this->user = Util::createUser();
        $otherPhone = '0813-3535-6767';

        $response = $this->postJson('/api/login', [
            'phone' => $otherPhone,
            'password' => $this->user->passwordPlain
        ]);

        $response->assertUnauthorized();
    }

    public function test_login_require_phone(): void
    {
        Util::setupDatabase();
        $this->user = Util::createUser();

        $response = $this->postJson('/api/login', [
            'password' => $this->user->passwordPlain
        ]);

        $response->assertJsonValidationErrors('phone');
    }

    public function test_login_require_valid_format_phone(): void
    {
        Util::setupDatabase();
        $invalidPhone = '0812 2890 0011';

        $response = $this->postJson('/api/login', [
            'phone' => $invalidPhone,
            'password' => fake()->password()
        ]);

        $response->assertJsonValidationErrors([
            'phone' => 'The phone is not an Indonesian phone number of the required format'
        ]);
    }

    public function test_login_require_password(): void
    {
        Util::setupDatabase();
        $this->user = Util::createUser();

        $response = $this->postJson('/api/login', [
            'phone' => $this->user->phone
        ]);

        $response->assertJsonValidationErrorFor('password');
    }
}
