<?php

namespace App\Modules\User\Repositories\Interfaces;

use App\Modules\User\Models\User;

interface UserRepositoryInterface
{
    public function findByEmail(string $email): ?User;

    public function createToken(User $user): string;
}
