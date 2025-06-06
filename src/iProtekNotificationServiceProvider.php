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
                \iProtek\SysNotification\Console\Commands\SmsScheduleCommand::class
            ]);
        }
 
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'iprotek_sys_notification');
        
        // Bootstrap package services
        $this->mergeConfigFrom(
            __DIR__ . '/../config/iprotek.php', 'iprotek_sys_notification'
        );
 
    }

    
    public function booted($callback){
        
        $this->app->booted(function () {
            //$schedule = $this->app->make(Schedule::class);
             $schedule = app(Schedule::class);
            // Schedule your command
            //$schedule->command('mypackage:run-task')->dailyAt('13:00');

            // Or inline task
            // $schedule->call(function () {
            //     Log::info('Running scheduled task from package...');
            // })->everyFiveMinutes(); 
            
            $schedule->command('iprotek:sys-notification-sms-schedule')
            ->everyMinute()
            ->onOneServer()
            ->runInBackground()
            ->withoutOverlapping();

        });
    }
}