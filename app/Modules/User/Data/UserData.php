<?php

namespace App\Modules\User\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public array $permissionIds = [],
        public array $roleIds = [],
        public array $organizationalChartIds = [],
    ) {}
}
