<?php

namespace Vns\Chatting;

use Illuminate\Support\ServiceProvider;

class ChattingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            // $this->publishes(
            //     [
            //         __DIR__ . '/../config/config.php' => config_path('chatting-backend.php'),
            //     ],
            //     'config'
            // );

            if (!class_exists('CreateChattingTables')) {
                $timestamp = date('Y_m_d_His', time());

                $this->publishes(
                    [
                        __DIR__ . '/../database/migrations/create_chatting_tables.php' => database_path('migrations/' . $timestamp . '_create_chatting_tables.php'),
                    ],
                    'migrations'
                );
            }
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'vns_chatting');

        // Register the main class to use with the facade
        $this->app->singleton('chatting-backend', fn () => $this->app->make(Chatting::class));
    }
}
