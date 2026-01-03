<?php

namespace App\Modules\AccessControl\Repositories\Interfaces;

use App\Modules\AccessControl\Data\RoleData;
use App\Modules\AccessControl\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    public function all(array $relations = []): Collection;

    public function create(RoleData $data): Role;

    public function update(Role $role, RoleData $data): bool;

    public function delete(Role $role): bool;
}
