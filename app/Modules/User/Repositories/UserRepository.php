<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\Data\UserData;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

readonly class UserRepository implements UserRepositoryInterface
{
    public function all(array $relations = []): Collection
    {
        return User::with($relations)->get();
    }

    public function create(UserData $data): User
    {
        return User::create($data->toArray());
    }

    public function createAndAssignPermissions(UserData $data): User
    {
        return DB::transaction(
            function () use ($data) {
                $user = $this->create($data);

                if (! empty($data->permissionIds)) {
                    $user->permissions()->attach($data->permissionIds);
                }

                if (! empty($data->roleIds)) {
                    $user->roles()->attach($data->roleIds);
                }

                if (! empty($data->organizationalChartIds)) {
                    $user->organizationalCharts()->attach($data->organizationalChartIds);
                }

                return $user;
            });
    }

    public function createToken(User $user): string
    {
        $token = $user->createToken(
            config('modules.authentication.token_key'),
            ['*'],
            now()->addHours(config('modules.authentication.token_ttl_hours')));

        return $token->plainTextToken;
    }

    public function findByEmail(string $email): ?User
    {
        return User::firstWhere('email', $email);
    }

    public function update(User $user, UserData $data): bool
    {
        return $user->update($data->toArray());
    }

    public function updateAndSyncPermissions(User $user, UserData $data): bool
    {
        return DB::transaction(
            function () use ($user, $data) {
                $updated = $this->update($user, $data);

                if (! empty($data->permissionIds)) {
                    $user->permissions()->sync($data->permissionIds);
                }

                if (! empty($data->roleIds)) {
                    $user->roles()->sync($data->roleIds);
                }

                if (! empty($data->organizationalChartIds)) {
                    $user->organizationalCharts()->sync($data->organizationalChartIds);
                }

                return $updated;
            });
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
