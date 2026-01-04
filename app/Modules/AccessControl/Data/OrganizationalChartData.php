<?php

namespace App\Modules\AccessControl\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class OrganizationalChartData extends Data
{
    public function __construct(
        public string $name,
        public array $permissionIds,
        public ?string $description = null,
    ) {}
}
