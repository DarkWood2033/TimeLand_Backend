<?php

namespace App\Providers;

use App\Services\Utils\EnvironmentUtil;
use App\Services\Utils\Module;
use Illuminate\Support\ServiceProvider;

class LangServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $namespace = Module::get();
        $this->loadTranslationsFrom(config('module.'.$namespace.'.lang'), $namespace);
    }
}
