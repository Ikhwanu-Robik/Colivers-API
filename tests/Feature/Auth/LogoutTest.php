<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Tests\Util\Auth\LoginUtil;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_require_active_bearer_token(): void
    {
        $response = $this->postJson('/api/logout');

        $response->assertUnauthorized();
    }

    public function test_user_can_logout(): void
    {
        $loginCredentials = LoginUtil::getLoginCredentialsWithout([]);
        $loginResponse = $this->postJson('/api/login', $loginCredentials);
        $bearerToken = 'Bearer ' . $loginResponse->json('token');
        $headers = [
            'Authorization' => $bearerToken
        ];
        $data = [];

        $logoutResponse = $this->postJson('/api/logout', $data, $headers);

        $logoutResponse->assertOk();
    }
}
