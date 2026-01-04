<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AccessControl\Services\AccessControlService;
use App\Modules\User\Data\UserData;
use App\Modules\User\Http\Requests\StoreUserRequest;
use App\Modules\User\Http\Requests\UpdateUserRequest;
use App\Modules\User\Http\Resources\UserResource;
use App\Modules\User\Models\User;
use App\Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly AccessControlService $accessControlService,
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function index(): JsonResponse
    {
        $this->accessControlService->isAbleTo('user.users.index');

        $users = $this->userRepository->all();

        return apiResponse()
            ->data($users)
            ->jsonResource(UserResource::class)
            ->get();
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->accessControlService->isAbleTo('user.users.store');

        $user = $this->userRepository->createAndAssignPermissions(UserData::from($request->validated()));

        return apiResponse()
            ->data($user)
            ->jsonResource(UserResource::class)
            ->message('The new user has been successfully created.')
            ->status(Response::HTTP_CREATED)
            ->get();
    }

    public function show(User $user): JsonResponse
    {
        $this->accessControlService->isAbleTo('user.users.show');

        return apiResponse()
            ->data($user)
            ->jsonResource(UserResource::class)
            ->get();
    }

    public function update(User $user, UpdateUserRequest $request): JsonResponse
    {
        $this->accessControlService->isAbleTo('user.users.update');

        $data = $request->validated();

        if (! $request->filled('password')) {
            $data['password'] = $user->password;
        }

        $this->userRepository->updateAndSyncPermissions($user, UserData::from($data));

        $this->accessControlService->clearUserPermissionsCache($user->id);

        return apiResponse()->message('The user has been successfully updated.')->get();
    }

    public function destroy(User $user): JsonResponse
    {
        $this->accessControlService->isAbleTo('user.users.destroy');

        if ($user->id === auth()->id()) {
            return apiResponse()
                ->message('You cannot delete your own user account.')
                ->status(Response::HTTP_FORBIDDEN)
                ->get();
        }

        $this->userRepository->delete($user);

        $this->accessControlService->clearUserPermissionsCache($user->id);

        return apiResponse()->message('The user has been successfully deleted.')->get();
    }
}
