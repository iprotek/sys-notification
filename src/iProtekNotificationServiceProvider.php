<?php

namespace iProtek\SysNotification;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class iProtekNotificationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register package services
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Bootstrap package services
        
        //$this->publishes([
        //    __DIR__.'/../database/migrations' => database_path('migrations'),
        //], 'migrations');

        
        /*
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/iprotek'),
        ], 'public');
        */ 
        
        if ($this->app->runningInConsole()) {
            //Log::info('iProtekNotificationServiceProvider booted');
            $this->commands([
                \iProtek\SysNotification\Console\Commands\IprotekSysNotificationTest::class,
            ]);
        }
 
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'iprotek_sys_notification');
 
    }
}