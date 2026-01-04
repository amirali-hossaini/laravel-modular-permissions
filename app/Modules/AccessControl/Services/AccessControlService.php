<?php

namespace App\Modules\AccessControl\Services;

use App\Modules\AccessControl\Exceptions\PermissionDeniedException;
use App\Modules\AccessControl\Models\OrganizationalChart;
use App\Modules\AccessControl\Models\Role;
use App\Modules\User\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

readonly class AccessControlService
{
    public function isAbleTo(string $permission, ?User $user = null): void
    {
        $user ??= auth()->user();

        if (! $user) {
            throw new PermissionDeniedException;
        }

        $cachedPermissions = $this->getCachedPermissions($user->id);

        if ($cachedPermissions?->contains($permission)) {
            return;
        }

        $freshPermissions = $this->loadAndCacheUserPermissions($user);

        if ($freshPermissions->contains($permission)) {
            return;
        }

        throw new PermissionDeniedException;
    }

    public function clearUserPermissionsCache(?int $userId = null): void
    {
        $userId ??= auth()->id();

        Cache::forget($this->cacheKey($userId));
    }

    public function clearPermissionsCacheForRoleUsers(Role $role): void
    {
        $userIds = $role->users()->pluck('users.id');

        foreach ($userIds as $userId) {
            $this->clearUserPermissionsCache($userId);
        }
    }

    public function clearPermissionsCacheForChartUsers(OrganizationalChart $chart): void
    {
        $userIds = $chart->users()->pluck('users.id');

        foreach ($userIds as $userId) {
            $this->clearUserPermissionsCache($userId);
        }
    }

    private function getCachedPermissions(int $userId): ?Collection
    {
        $cached = Cache::get($this->cacheKey($userId));

        if (! $cached instanceof Collection) {
            return null;
        }

        return $cached;
    }

    private function loadAndCacheUserPermissions(User $user): Collection
    {
        $user->load([
            'permissions',
            'roles.permissions',
            'organizationalCharts.permissions',
        ]);

        $permissions = collect()
            ->merge($user->permissions->pluck('name'))
            ->merge($user->roles->flatMap->permissions->pluck('name'))
            ->merge($user->organizationalCharts->flatMap->permissions->pluck('name'))
            ->unique()
            ->values();

        Cache::put(
            $this->cacheKey($user->id),
            $permissions,
            now()->addMinutes(config('modules.access_control.cache.ttl_minutes')),
        );

        return $permissions;
    }

    private function cacheKey(int $userId): string
    {
        return config('modules.access_control.cache.prefix').$userId;
    }
}
