<?php

namespace Database\Seeders;

use App\Modules\AccessControl\Models\OrganizationalChart;
use App\Modules\AccessControl\Models\Permission;
use App\Modules\AccessControl\Models\Role;
use App\Modules\Blog\Models\Post;
use App\Modules\User\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // permissions
        $this->call(PermissionSeeder::class);

        // users
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // roles
        $role = Role::factory()->create([
            'name' => 'admin',
        ]);

        $role->permissions()->attach(Permission::pluck('id')->toArray());

        $user->roles()->attach($role);

        // posts
        Post::factory()->count(5)->state(['user_id' => $user->id])->create();
        Post::factory()->count(10)->create();

        // organizational charts
        $chart = OrganizationalChart::factory()->create([
            'name' => 'Management',
        ]);

        $user->organizationalCharts()->attach($chart);
    }
}
