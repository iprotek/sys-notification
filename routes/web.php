<?php

use Illuminate\Support\Facades\Route; 
use iProtek\SysNotification\Http\Controllers\SysNotificationController;
use iProtek\SysNotification\Http\Controllers\SysNotifySchedulerController;
use iProtek\SysNotification\Http\Controllers\SysNotifyScheduleSmsTriggerController;
use iProtek\SysNotification\Http\Controllers\SysNotifyScheduleEmailTriggerController;
use iProtek\SysNotification\Http\Controllers\SysNotifyScheduleNotificationTriggerController;

include(__DIR__.'/api.php');

Route::middleware(['web'])->group(function(){
 
  Route::middleware(['auth:admin'])->prefix('manage/sys-notification')->name('manage.sys-notification')->group(function(){
    //Route::get('/test', [SysNotificationController::class, 'index'])->name('.test');
    Route::get('/',  [SysNotificationController::class, 'index'])
      ->defaults("_description","System notification index")
      ->defaults("_is_visible",true)
      ->defaults("_is_allow",false)
      ->name('.index');

    Route::get('/system-updates',  [SysNotificationController::class, 'system_updates'])
      ->defaults("_description","Render system updates")
      ->defaults("_is_visible",false)
      ->defaults("_is_allow",false)
      ->name('.system-updates');

    Route::post('/check-system-updates', [SysNotificationController::class, 'check_system_updates'])
      ->defaults("_description","Check system updates")
      ->defaults("_is_visible",false)
      ->defaults("_is_allow",false)
      ->name('.check-system-updates');

    Route::get('/check-system-updates', [SysNotificationController::class, 'check_system_updates'])
      ->defaults("_description","Check system updates")
      ->defaults("_is_visible",false)
      ->defaults("_is_allow",false)
      ->name('.get-check-system-updates');

    Route::get('/system-updates-summary', [SysNotificationController::class, 'system_updates_summary'])
      ->defaults("_description","Preview system updates")
      ->defaults("_is_visible",false)
      ->defaults("_is_allow",false)
      ->name('.check-system-summary');

    Route::post('/apply-system-updates', [SysNotificationController::class, 'apply_system_updates'])
      ->defaults("_description","Apply system updates")
      ->defaults("_is_visible",false)
      ->defaults("_is_allow",false)
      ->name('.apply-system-updates');
  
    Route::get('clear',  [SysNotificationController::class, 'clear_notification'])
      ->defaults("_description","Clear notification")
      ->defaults("_is_visible",false)
      ->defaults("_is_allow",false)
      ->name('.clear');
    
    Route::prefix('scheduler')->name('.manage-notify-scheduler')->group(function(){

      Route::get('/',  [SysNotifySchedulerController::class, 'index'])
        ->defaults("_description","Scheduler Index View")
        ->defaults("_is_visible",false)
        ->defaults("_is_allow",false)
      ->name('.index');
    
      //TODO:: 
      Route::prefix('triggers')->name('.triggers')->group(function(){

        Route::get('sms/{scheduler}',  [SysNotifyScheduleSmsTriggerController::class, 'index'])
          ->defaults("_description","Sms triggers in a scheduler")
          ->defaults("_is_visible",false)
          ->defaults("_is_allow",false)
        ->name('.sms-index');

        //TODO::Route::prefix('/email', )
        Route::get('email/{scheduler}',  [SysNotifyScheduleEmailTriggerController::class, 'index'])
          ->defaults("_description","Email triggers in a scheduler")
          ->defaults("_is_visible",false)
          ->defaults("_is_allow",false)
          ->name('.email-index');
        
        //TODO::Route::prefix('/notification', )
        Route::get('notification/{scheduler}',  [SysNotifyScheduleNotificationTriggerController::class, 'index'])
          ->defaults("_description","System notification triggers in a scheduler")
          ->defaults("_is_visible",false)
          ->defaults("_is_allow",false)
          ->name('.index');

      });
    
    });
  
  });
 

});