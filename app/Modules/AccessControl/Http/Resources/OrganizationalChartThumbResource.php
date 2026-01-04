<?php

namespace App\Modules\AccessControl\Http\Resources;

use Omalizadeh\ApiResponse\Resources\BaseApiResource;
use App\Modules\AccessControl\Http\Resources\PermissionResource;

class OrganizationalChartThumbResource extends BaseApiResource
{
    protected function transformDataItem($item): array
    {
        return [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'permissions' => PermissionResource::collection($item->permissions),
        ];
    }
}
