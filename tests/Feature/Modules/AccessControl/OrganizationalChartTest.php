<?php

namespace Tests\Feature\Modules\AccessControl;

use App\Modules\AccessControl\Models\OrganizationalChart;
use App\Modules\AccessControl\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationalChartTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = 'api/v1/access-control/organizational-charts';

    public function test_organizational_charts_index_returns_correct_structure(): void
    {
        $this->hasPermission('access_control.organizational_charts.index');

        OrganizationalChart::factory()->count(5)->create();

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

    public function test_organizational_chart_store_creates_new_chart(): void
    {
        $this->hasPermission('access_control.organizational_charts.store');

        $data = [
            'name' => 'Test Department',
            'description' => 'This is a test organizational unit.',
            'permission_ids' => [1, 2],
        ];

        $response = $this->post(self::API_PREFIX, $data)
            ->assertCreated()
            ->assertJsonFragment([
                'name' => $data['name'],
                'description' => $data['description'],
            ]);

        $this->assertDatabaseHas('organizational_charts', [
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        $this->assertDatabaseHas('organizational_chart_permission', [
            'organizational_chart_id' => $response->json('data.id'),
            'permission_id' => 1,
        ]);

        $this->assertDatabaseHas('organizational_chart_permission', [
            'organizational_chart_id' => $response->json('data.id'),
            'permission_id' => 2,
        ]);
    }

    public function test_organizational_chart_show_returns_correct_structure_with_permissions(): void
    {
        $this->hasPermission('access_control.organizational_charts.show');

        $chart = OrganizationalChart::factory()->create();

        $chart->permissions()->attach(Permission::pluck('id')->toArray());

        $this->get(self::API_PREFIX.'/'.$chart->id)
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

    public function test_organizational_chart_update_modifies_existing_one(): void
    {
        $this->hasPermission('access_control.organizational_charts.update');

        $chart = OrganizationalChart::factory()->create();

        $updatedData = [
            'name' => 'Updated Department Name',
            'description' => 'Updated organizational unit description.',
            'permission_ids' => [1, 3, 5],
        ];

        $this->patch(self::API_PREFIX.'/'.$chart->id, $updatedData)
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'The organizational chart has been successfully updated.',
            ]);

        $this->assertDatabaseHas('organizational_charts', [
            'id' => $chart->id,
            'name' => $updatedData['name'],
            'description' => $updatedData['description'],
        ]);

        $this->assertDatabaseHas('organizational_chart_permission', [
            'organizational_chart_id' => $chart->id,
            'permission_id' => 1,
        ]);

        $this->assertDatabaseHas('organizational_chart_permission', [
            'organizational_chart_id' => $chart->id,
            'permission_id' => 3,
        ]);

        $this->assertDatabaseHas('organizational_chart_permission', [
            'organizational_chart_id' => $chart->id,
            'permission_id' => 5,
        ]);
    }

    public function test_organizational_chart_destroy_deletes_chart(): void
    {
        $this->hasPermission('access_control.organizational_charts.destroy');

        $chart = OrganizationalChart::factory()->create();

        $this->delete(self::API_PREFIX.'/'.$chart->id)
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'The organizational chart has been successfully deleted.',
            ]);

        $this->assertDatabaseMissing('organizational_charts', ['id' => $chart->id]);
    }
}
