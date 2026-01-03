<?php

namespace App\Modules\AccessControl\Repositories;

use App\Modules\AccessControl\Data\RoleData;
use App\Modules\AccessControl\Models\Role;
use App\Modules\AccessControl\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

readonly class RoleRepository implements RoleRepositoryInterface
{
    public function all(array $relations = []): Collection
    {
        return Role::with($relations)->get();
    }

    public function create(RoleData $data): Role
    {
        return DB::transaction(function () use ($data) {
            $role = Role::create($data->toArray());

            $role->permissions()->attach($data->permissionIds);

            return $role;
        });
    }

    public function update(Role $role, RoleData $data): bool
    {
        return DB::transaction(function () use ($role, $data) {
            $updated = $role->update($data->toArray());

            $role->permissions()->sync($data->permissionIds);

            return $updated;
        });
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }
}
