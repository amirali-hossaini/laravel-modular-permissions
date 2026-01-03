<?php

namespace App\Modules\AccessControl\Services;

use App\Modules\AccessControl\Exceptions\PermissionDeniedException;
use App\Modules\User\Models\User;

readonly class AccessControlService
{
    public function isAbleTo(string $permission, ?User $user = null): void
    {
        $user ??= auth()->user();

        $user->load(['permissions', 'roles.permissions', 'organizationalCharts.permissions']);

        if ($user->permissions->contains('name', $permission)) {
            return;
        }

        foreach ($user->roles as $role) {
            if ($role->permissions->contains('name', $permission)) {
                return;
            }
        }

        foreach ($user->organizationalCharts as $organizationalChart) {
            if ($organizationalChart->permissions->contains('name', $permission)) {
                return;
            }
        }

        throw new PermissionDeniedException;
    }
}
