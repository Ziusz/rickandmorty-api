<?php

namespace App\Providers;

use App\Contracts\CharacterAPIServiceInterface;
use App\Contracts\CharacterRepositoryInterface;
use App\Contracts\CharacterServiceInterface;
use App\Repositories\CharacterRepository;
use App\Services\CharacterAPIService;
use App\Services\CharacterService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CharacterServiceInterface::class, CharacterService::class);
        $this->app->bind(CharacterAPIServiceInterface::class, CharacterAPIService::class);
        $this->app->bind(CharacterRepositoryInterface::class, CharacterRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
