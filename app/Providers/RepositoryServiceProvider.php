<?php

namespace App\Providers;

use App\Repositories\Eloquent\Admon\RoleRepository;
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
    }

    public function boot()
    {
        //
    }
}
