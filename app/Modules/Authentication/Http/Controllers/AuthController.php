<?php

namespace App\Modules\Authentication\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Authentication\Http\Requests\LoginRequest;
use App\Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userRepository->findByEmail($request->validated('email'));

        if (is_null($user)) {
            return $this->usernameOrPasswordIsIncorrectResponse();
        }

        if (! Hash::check($request->validated('password'), $user->password)) {
            return $this->usernameOrPasswordIsIncorrectResponse();
        }

        $token = $this->userRepository->createToken($user);

        return apiResponse()
            ->data(['token' => $token])
            ->message('Welcome back!')
            ->get();
    }

    private function usernameOrPasswordIsIncorrectResponse(): JsonResponse
    {
        return apiResponse()->errorMessage('Username or password is incorrect.')->get();
    }
}
