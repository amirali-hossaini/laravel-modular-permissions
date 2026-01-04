<?php

namespace Tests\Feature\Modules\AccessControl;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = 'api/v1/access-control/permissions';

    public function test_permissions_index_returns_correct_structure(): void
    {
        $this->hasPermission('access_control.permissions.index');

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
}
