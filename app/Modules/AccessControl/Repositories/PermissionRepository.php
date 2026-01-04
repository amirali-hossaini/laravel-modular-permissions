<?php

namespace App\Modules\AccessControl\Repositories;

use App\Modules\AccessControl\Models\Permission;
use App\Modules\AccessControl\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class PermissionRepository implements PermissionRepositoryInterface
{
    public function all(array $relations = []): Collection
    {
        return Permission::with($relations)->get();
    }
}
