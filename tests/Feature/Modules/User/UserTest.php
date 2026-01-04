<?php

namespace Tests\Feature\Modules\User;

use App\Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = 'api/v1/users';

    public function test_users_index_returns_correct_structure(): void
    {
        $this->hasPermission('user.users.index');

        User::factory()->count(5)->create();

        $this->get(self::API_PREFIX)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);
    }

    public function test_user_store_creates_new_user(): void
    {
        $this->hasPermission('user.users.store');

        $data = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password',
            'permission_ids' => [1, 2],
        ];

        $response = $this->post(self::API_PREFIX, $data)
            ->assertCreated()
            ->assertJsonFragment([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        $this->assertDatabaseHas('permission_user', [
            'user_id' => $response->json('data.id'),
            'permission_id' => 1,
        ]);

        $this->assertDatabaseHas('permission_user', [
            'user_id' => $response->json('data.id'),
            'permission_id' => 2,
        ]);
    }

    public function test_user_show_returns_correct_structure(): void
    {
        $this->hasPermission('user.users.show');

        $user = User::factory()->create();

        $this->get(self::API_PREFIX.'/'.$user->id)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                ],
            ]);
    }

    public function test_user_update_modifies_existing_user(): void
    {
        $this->hasPermission('user.users.update');

        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Updated User Name',
            'email' => 'updated@example.com',
            'permission_ids' => [3, 4],
        ];

        $this->patch(self::API_PREFIX.'/'.$user->id, $updatedData)
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'The user has been successfully updated.',
            ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $updatedData['name'],
            'email' => $updatedData['email'],
        ]);

        $this->assertDatabaseHas('permission_user', [
            'user_id' => $user->id,
            'permission_id' => 3,
        ]);

        $this->assertDatabaseHas('permission_user', [
            'user_id' => $user->id,
            'permission_id' => 4,
        ]);
    }

    public function test_user_destroy_deletes_user(): void
    {
        $this->hasPermission('user.users.destroy');

        $user = User::factory()->create();

        $this->delete(self::API_PREFIX.'/'.$user->id)
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'The user has been successfully deleted.',
            ]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
