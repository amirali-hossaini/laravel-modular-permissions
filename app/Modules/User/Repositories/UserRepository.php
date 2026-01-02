<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\Models\User;
use App\Modules\User\Repositories\Interfaces\UserRepositoryInterface;

readonly class UserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): ?User
    {
        return User::firstWhere('email', $email);
    }

    public function createToken(User $user): string
    {
        $token = $user->createToken(
            config('modules.authentication.token_key'),
            ['*'],
            now()->addHours(config('modules.authentication.token_ttl_hours')));

        return $token->plainTextToken;
    }
}
