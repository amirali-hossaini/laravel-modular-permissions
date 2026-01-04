<?php

namespace Tests;

use App\Modules\AccessControl\Models\Permission;
use App\Modules\User\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionSeeder::class);

        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);
    }

    protected function hasPermission(string $permissionName): void
    {
        $permission = Permission::firstOrCreate([
            'name' => $permissionName,
        ]);

        $this->user->permissions()->attach($permission->id);
    }
}
