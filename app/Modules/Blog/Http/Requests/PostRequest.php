<?php

namespace App\Modules\Blog\Http\Requests;

use App\Modules\Blog\Models\Post;
use Illuminate\Validation\Rule;
use Omalizadeh\ApiResponse\Requests\BaseApiRequest;

class PostRequest extends BaseApiRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'slug' => [
                'required',
                'string',
                Rule::unique(Post::class, 'slug')->ignore($this->post?->id),
                'max:255',
            ],
            'body' => [
                'required',
                'string',
                'max:5000',
            ],
        ];
    }
}
