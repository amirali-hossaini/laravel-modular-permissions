<?php

namespace App\Modules\AccessControl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AccessControl\Http\Resources\PermissionThumbResource;
use App\Modules\AccessControl\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Modules\AccessControl\Services\AccessControlService;
use Illuminate\Http\JsonResponse;

class PermissionController extends Controller
{
    public function __construct(
        private readonly AccessControlService $accessControlService,
        private readonly PermissionRepositoryInterface $permissionRepository,
    ) {}

    public function index(): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.permissions.index');

        $permissions = $this->permissionRepository->all();

        return apiResponse()
            ->data($permissions)
            ->jsonResource(PermissionThumbResource::class)
            ->get();
    }
}
