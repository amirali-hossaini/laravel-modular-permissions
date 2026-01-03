<?php

namespace App\Modules\User\Repositories\Interfaces;

use App\Modules\User\Data\UserData;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function all(array $relations = []): Collection;

    public function create(UserData $data): User;

    public function createAndAssignPermissions(UserData $data): User;

    public function createToken(User $user): string;

    public function findByEmail(string $email): ?User;

    public function update(User $user, UserData $data): bool;

    public function updateAndSyncPermissions(User $user, UserData $data): bool;

    public function delete(User $user): bool;
}
