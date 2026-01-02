<?php

namespace App\Modules\Blog\Repositories\Interfaces;

use App\Modules\Blog\Data\PostData;
use App\Modules\Blog\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostRepositoryInterface
{
    public function all(array $relations = []): Collection;

    public function create(PostData $data): Post;

    public function findBySlug(string $slug): ?Post;

    public function update(Post $post, array $data): bool;

    public function delete(Post $post): bool;
}
