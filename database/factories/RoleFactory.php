<?php

namespace Database\Factories;

use App\Modules\AccessControl\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(),
        ];
    }
}
