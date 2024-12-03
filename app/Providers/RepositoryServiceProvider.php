<?php

namespace App\Providers;

use App\Repositories\Eloquent\Admon\ActionRepository;
use App\Repositories\Eloquent\Admon\MenuRepository;
use App\Repositories\Eloquent\Admon\ModuleRepository;
use App\Repositories\Eloquent\Admon\PermissionRepository;
use App\Repositories\Eloquent\Admon\RoleRepository;
use App\Repositories\Interfaces\Admon\ActionRepositoryInterface;
use App\Repositories\Interfaces\Admon\MenuRepositoryInterface;
use App\Repositories\Interfaces\Admon\ModuleRepositoryInterface;
use App\Repositories\Interfaces\Admon\PermissionRepositoryInterface;
use App\Repositories\Interfaces\Admon\RoleRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(ModuleRepositoryInterface::class, ModuleRepository::class);
        $this->app->bind(MenuRepositoryInterface::class, MenuRepository::class);
        $this->app->bind(ActionRepositoryInterface::class, ActionRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    public function boot()
    {
        //
    }
}
