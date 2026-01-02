<?php

namespace App\Modules\Blog\Data;

use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class PostData extends Data
{
    public function __construct(
        public int $userId,
        public string $title,
        public string $slug,
        public string $body,
    ) {}
}
