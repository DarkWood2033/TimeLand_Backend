<?php

namespace App\Providers;

use App\Services\Caching\CachingRepository;
use App\Services\Caching\IlluminateCachingRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(CachingRepository::class, IlluminateCachingRepository::class);

        JsonResource::withoutWrapping();
    }
}
