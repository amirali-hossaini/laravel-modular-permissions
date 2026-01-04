<?php

namespace Tests\Feature\Modules\AccessControl;

use App\Modules\AccessControl\Models\Permission;
use App\Modules\AccessControl\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = 'api/v1/access-control/roles';

    public function test_roles_index_returns_correct_structure(): void
    {
        $this->hasPermission('access_control.roles.index');

        Role::factory()->count(5)->create();

        $this->get(self::API_PREFIX)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                    ],
                ],
            ]);
    }

    public function test_role_store_creates_new_role(): void
    {
        $this->hasPermission('access_control.roles.store');

        $data = [
            'name' => 'Test Role',
            'description' => 'This is a test role.',
            'permission_ids' => [2, 3, 4],
        ];

        $response = $this->post(self::API_PREFIX, $data)
            ->assertCreated()
            ->assertJsonFragment([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

        unset($data['permission_ids']);

        $this->assertDatabaseHas('roles', $data);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => 2,
            'role_id' => $response->json('data.id'),
        ]);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => 3,
            'role_id' => $response->json('data.id'),
        ]);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => 4,
            'role_id' => $response->json('data.id'),
        ]);
    }

    public function test_role_show_returns_correct_structure_with_permissions(): void
    {
        $this->hasPermission('access_control.roles.show');

        $role = Role::factory()->create();

        $role->permissions()->attach(Permission::pluck('id')->toArray());

        $this->get(self::API_PREFIX.'/'.$role->id)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'permissions' => [
                        '*' => [
                            'id',
                            'name',
                            'description',
                        ],
                    ],
                ],
            ]);
    }

    public function test_role_update_modifies_existing_role(): void
    {
        $this->hasPermission('access_control.roles.update');

        $role = Role::factory()->create();

        $updatedData = [
            'name' => 'Updated Role Name',
            'description' => 'Updated description.',
            'permission_ids' => [1, 2],
        ];

        $this->patch(self::API_PREFIX.'/'.$role->id, $updatedData)
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'The role has been successfully updated.',
            ]);

        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'name' => $updatedData['name'],
            'description' => $updatedData['description'],
        ]);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => 1,
            'role_id' => $role->id,
        ]);

        $this->assertDatabaseHas('permission_role', [
            'permission_id' => 2,
            'role_id' => $role->id,
        ]);
    }

    public function test_role_destroy_deletes_role(): void
    {
        $this->hasPermission('access_control.roles.destroy');

        $role = Role::factory()->create();

        $this->delete(self::API_PREFIX.'/'.$role->id)
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'The role has been successfully deleted.',
            ]);

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}
