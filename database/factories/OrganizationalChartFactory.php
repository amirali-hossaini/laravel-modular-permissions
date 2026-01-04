<?php

namespace Database\Factories;

use App\Modules\AccessControl\Models\OrganizationalChart;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationalChartFactory extends Factory
{
    protected $model = OrganizationalChart::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
        ];
    }
}
