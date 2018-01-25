<?php

namespace MatviiB\Scheduler;

use Illuminate\Support\ServiceProvider;

class SchedulerServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\Show::class,
                Console\Commands\Create::class,
            ]);

            $this->publishes([
                __DIR__ . '/config/scheduler.php' => config_path('scheduler.php'),
            ], 'config');
        }

        $this->loadMigrationsFrom(__DIR__.'/migrations');

        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        $this->loadViewsFrom(__DIR__.'/views', 'scheduler');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

    }
}