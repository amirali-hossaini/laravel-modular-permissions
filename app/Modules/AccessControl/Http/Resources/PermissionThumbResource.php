<?php

namespace App\Modules\AccessControl\Http\Resources;

use Omalizadeh\ApiResponse\Resources\BaseApiResource;

class PermissionThumbResource extends BaseApiResource
{
    protected function transformDataItem($item): array
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
        ];
    }
}
