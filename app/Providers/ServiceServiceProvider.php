<?php

namespace App\Providers;

use App\Contracts\CategoryServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProductServiceInterface;
use App\Services\CategoryService;
use App\Services\ProductService;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
