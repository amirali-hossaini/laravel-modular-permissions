<?php

namespace App\Modules\User\Http\Resources;

use Omalizadeh\ApiResponse\Resources\BaseApiResource;

class UserResource extends BaseApiResource
{
    protected function transformDataItem($item): array
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'email' => $item->email,
        ];
    }
}
