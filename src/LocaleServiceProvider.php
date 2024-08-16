<?php

namespace Laraflow\Local;

use Illuminate\Support\ServiceProvider;
use Laraflow\Local\Commands\InstallCommand;

class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/local.php', 'fintech.local'
        );

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/local.php' => config_path('fintech/local.php'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'local');

        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/local'),
        ]);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'local');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/local'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }
}
