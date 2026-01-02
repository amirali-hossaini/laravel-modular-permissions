<?php

namespace App\Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Data\PostData;
use App\Modules\Blog\Http\Requests\PostRequest;
use App\Modules\Blog\Http\Resources\PostResource;
use App\Modules\Blog\Models\Post;
use App\Modules\Blog\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
    ) {}

    public function index(): JsonResponse
    {
        $posts = $this->postRepository->all(['user']);

        return apiResponse()
            ->data($posts)
            ->jsonResource(PostResource::class)
            ->get();
    }

    public function store(PostRequest $request): JsonResponse
    {
        $post = $this->postRepository->create(PostData::from([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]));

        return apiResponse()
            ->data($post)
            ->jsonResource(PostResource::class)
            ->message('The new post has been successfully created.')
            ->status(Response::HTTP_CREATED)
            ->get();
    }

    public function show(Post $post): JsonResponse
    {
        return apiResponse()
            ->data($post->load('user'))
            ->jsonResource(PostResource::class)
            ->get();
    }

    public function update(Post $post, PostRequest $request): JsonResponse
    {
        $this->postRepository->update($post, $request->validated());

        return apiResponse()->message('The post has been successfully updated.')->get();
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->postRepository->delete($post);

        return apiResponse()->message('The post has been successfully deleted.')->get();
    }
}
