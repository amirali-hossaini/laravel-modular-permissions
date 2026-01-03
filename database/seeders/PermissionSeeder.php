<?php

namespace Database\Seeders;

use App\Modules\AccessControl\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(static function () {
            Permission::query()->delete();

            $data = [
                [
                    'id' => 1,
                    'name' => 'blog.posts.index',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'name' => 'blog.posts.store',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'name' => 'blog.posts.show',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 4,
                    'name' => 'blog.posts.update',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 5,
                    'name' => 'blog.posts.destroy',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 6,
                    'name' => 'access_control.roles.index',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 7,
                    'name' => 'access_control.roles.store',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 8,
                    'name' => 'access_control.roles.show',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 9,
                    'name' => 'access_control.roles.update',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 10,
                    'name' => 'access_control.roles.destroy',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 11,
                    'name' => 'access_control.permissions.index',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 12,
                    'name' => 'access_control.organizational_charts.index',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 13,
                    'name' => 'access_control.organizational_charts.store',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 14,
                    'name' => 'access_control.organizational_charts.show',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 15,
                    'name' => 'access_control.organizational_charts.update',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 16,
                    'name' => 'access_control.organizational_charts.destroy',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 17,
                    'name' => 'user.users.index',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 18,
                    'name' => 'user.users.store',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 19,
                    'name' => 'user.users.show',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 20,
                    'name' => 'user.users.update',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 21,
                    'name' => 'user.users.destroy',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            Permission::insertOrIgnore($data);
        });
    }
}
