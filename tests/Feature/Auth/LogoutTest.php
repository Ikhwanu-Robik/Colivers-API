<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Tests\Feature\Auth\Util;

class LogoutTest extends TestCase
{
    private $user;

    public function test_logout_require_active_bearer_token(): void
    {
        Util::setupDatabase();

        $response = $this->postJson('/api/logout');

        $response->assertUnauthorized();
    }

    public function test_user_can_logout(): void
    {
        Util::setupDatabase();
        $this->user = Util::createUser();
        $loginResponse = $this->postJson('/api/login', [
            'phone' => $this->user->phone,
            'password' => $this->user->passwordPlain
        ]);
        $bearerToken = 'Bearer ' . $loginResponse->json('token');

        $logoutResponse = $this->postJson('/api/logout', [], [
            'Authorization' => $bearerToken
        ]);

        $logoutResponse->assertOk();
    }
}
