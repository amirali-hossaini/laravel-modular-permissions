<?php

namespace App\Modules\Blog\Http\Resources;

use App\Modules\User\Http\Resources\UserThumbResource;
use Omalizadeh\ApiResponse\Resources\BaseApiResource;

class PostResource extends BaseApiResource
{
    protected function transformDataItem($item): array
    {
        return [
            'id' => $item->id,
            'title' => $item->title,
            'slug' => $item->slug,
            'body' => $item->body,
            'created_at' => $item->created_at,
            'user' => new UserThumbResource($item->user),
        ];
    }
}
