<?php

namespace Tests\Feature\Modules\Blog;

use App\Modules\Blog\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = 'api/v1/blog/posts';

    public function test_posts_index_returns_correct_structure(): void
    {
        $this->hasPermission('blog.posts.index');

        Post::factory()->count(5)->create();

        $this->get(self::API_PREFIX)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'slug',
                        'body',
                        'created_at',
                        'user' => [
                            'id',
                            'name',
                            'email',
                        ],
                    ],
                ],
            ]);
    }

    public function test_post_store_creates_new_post(): void
    {
        $this->hasPermission('blog.posts.store');

        $data = [
            'title' => 'Test Post Title',
            'slug' => 'test-post-title',
            'body' => 'This is the body of the test post.',
        ];

        $this->post(self::API_PREFIX, $data)
            ->assertCreated()
            ->assertJsonFragment([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'body' => $data['body'],
            ]);

        $this->assertDatabaseHas('posts', [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'body' => $data['body'],
            'user_id' => auth()->id(),
        ]);
    }

    public function test_post_show_returns_correct_structure_with_user(): void
    {
        $this->hasPermission('blog.posts.show');

        $post = Post::factory()->create();

        $this->get(self::API_PREFIX.'/'.$post->id)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'slug',
                    'body',
                    'created_at',
                    'user' => [
                        'id',
                        'name',
                        'email',
                    ],
                ],
            ]);
    }

    public function test_post_update_modifies_existing_post(): void
    {
        $this->hasPermission('blog.posts.update');

        $post = Post::factory()->create();

        $updatedData = [
            'title' => 'Updated Post Title',
            'slug' => 'updated-post-title',
            'body' => 'This is the updated body content.',
        ];

        $this->patch(self::API_PREFIX.'/'.$post->id, $updatedData)
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'The post has been successfully updated.',
            ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $updatedData['title'],
            'slug' => $updatedData['slug'],
            'body' => $updatedData['body'],
        ]);
    }

    public function test_post_destroy_deletes_post(): void
    {
        $this->hasPermission('blog.posts.destroy');

        $post = Post::factory()->create();

        $this->delete(self::API_PREFIX.'/'.$post->id)
            ->assertOk()
            ->assertJsonFragment([
                'message' => 'The post has been successfully deleted.',
            ]);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
