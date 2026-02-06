<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Repositories
        $this->app->bind(
            \App\Repositories\Interfaces\DivisionRepositoryInterface::class,
            \App\Repositories\Eloquents\DivisionRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\EmployeeRepositoryInterface::class,
            \App\Repositories\Eloquents\EmployeeRepository::class
        );

        // Services
        $this->app->bind(
            \App\Services\AuthServiceInterface::class,
            \App\Services\AuthService::class
        );
         $this->app->bind(
            \App\Services\DivisionServiceInterface::class,
            \App\Services\DivisionService::class
        );
         $this->app->bind(
            \App\Services\EmployeeServiceInterface::class,
            \App\Services\EmployeeService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
