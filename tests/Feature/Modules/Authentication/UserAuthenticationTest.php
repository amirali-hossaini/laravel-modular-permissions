<?php

namespace Tests\Feature\Modules\Authentication;

use App\Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = 'api/v1/authentication/login';

    public function test_successful_login_returns_token(): void
    {
        $user = User::factory()->create();

        $loginData = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->post(self::API_PREFIX, $loginData);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'token',
                ],
            ])
            ->assertJsonFragment([
                'message' => 'Welcome back!',
            ]);

        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_failed_login_with_wrong_password_returns_error(): void
    {
        $user = User::factory()->create();

        $loginData = [
            'email' => $user->email,
            'password' => 'wrong-password',
        ];

        $response = $this->post(self::API_PREFIX, $loginData);

        $response
            ->assertUnprocessable()
            ->assertJsonFragment([
                'message' => 'Username or password is incorrect.',
            ]);

        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->id,
        ]);
    }

    public function test_login_with_non_existent_email_returns_error(): void
    {
        $loginData = [
            'email' => 'nonexistent@example.com',
            'password' => 'password',
        ];

        $response = $this->post(self::API_PREFIX, $loginData);

        $response
            ->assertUnprocessable()
            ->assertJsonFragment([
                'message' => 'Username or password is incorrect.',
            ]);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }
}
