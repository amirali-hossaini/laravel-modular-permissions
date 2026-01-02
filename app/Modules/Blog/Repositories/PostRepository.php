<?php

namespace App\Modules\Blog\Repositories;

use App\Modules\Blog\Data\PostData;
use App\Modules\Blog\Models\Post;
use App\Modules\Blog\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class PostRepository implements PostRepositoryInterface
{
    public function all(array $relations = []): Collection
    {
        return Post::with($relations)->get();
    }

    public function create(PostData $data): Post
    {
        return Post::create($data->toArray());
    }

    public function findBySlug(string $slug): ?Post
    {
        return Post::firstWhere('slug', $slug);
    }

    public function update(Post $post, array $data): bool
    {
        return $post->update($data);
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }
}
