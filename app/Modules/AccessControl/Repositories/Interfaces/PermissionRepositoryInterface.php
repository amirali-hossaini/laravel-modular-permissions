<?php

namespace App\Modules\AccessControl\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface
{
    public function all(array $relations = []): Collection;
}
