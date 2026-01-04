<?php

namespace App\Providers;

use App\Modules\AccessControl\Repositories\Interfaces\OrganizationalChartRepositoryInterface;
use App\Modules\AccessControl\Repositories\Interfaces\RoleRepositoryInterface;
use App\Modules\AccessControl\Repositories\OrganizationalChartRepository;
use App\Modules\AccessControl\Repositories\RoleRepository;
use App\Modules\Blog\Repositories\Interfaces\PostRepositoryInterface;
use App\Modules\Blog\Repositories\PostRepository;
use App\Modules\User\Repositories\Interfaces\UserRepositoryInterface;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UserRepositoryInterface::class, UserRepository::class);
        $this->app->singleton(PostRepositoryInterface::class, PostRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->singleton(OrganizationalChartRepositoryInterface::class, OrganizationalChartRepository::class);
    }
}
