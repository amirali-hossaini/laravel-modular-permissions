<?php

namespace App\Modules\AccessControl\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AccessControl\Data\RoleData;
use App\Modules\AccessControl\Http\Requests\RoleRequest;
use App\Modules\AccessControl\Http\Resources\RoleResource;
use App\Modules\AccessControl\Http\Resources\RoleThumbResource;
use App\Modules\AccessControl\Models\Role;
use App\Modules\AccessControl\Repositories\Interfaces\RoleRepositoryInterface;
use App\Modules\AccessControl\Services\AccessControlService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    public function __construct(
        private readonly AccessControlService $accessControlService,
        private readonly RoleRepositoryInterface $roleRepository,
    ) {}

    public function index(): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.roles.index');

        $roles = $this->roleRepository->all();

        return apiResponse()
            ->data($roles)
            ->jsonResource(RoleResource::class)
            ->get();
    }

    public function store(RoleRequest $request): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.roles.store');

        $role = $this->roleRepository->create(RoleData::from($request->validated()));

        return apiResponse()
            ->data($role)
            ->jsonResource(RoleResource::class)
            ->message('The new role has been successfully created.')
            ->status(Response::HTTP_CREATED)
            ->get();
    }

    public function show(Role $role): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.roles.show');

        return apiResponse()
            ->data($role->load('permissions'))
            ->jsonResource(RoleThumbResource::class)
            ->get();
    }

    public function update(Role $role, RoleRequest $request): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.roles.update');

        $this->roleRepository->update($role, RoleData::from($request->validated()));

        return apiResponse()->message('The role has been successfully updated.')->get();
    }

    public function destroy(Role $role): JsonResponse
    {
        $this->accessControlService->isAbleTo('access_control.roles.destroy');

        $this->roleRepository->delete($role);

        return apiResponse()->message('The role has been successfully deleted.')->get();
    }
}
