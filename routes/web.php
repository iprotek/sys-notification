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
    Route::get('/test', [SysNotificationController::class, 'index'])->name('.test');
    Route::get('/', [SysNotificationController::class, 'index'])->name('.index');
    Route::get('/system-updates', [SysNotificationController::class, 'system_updates'])->name('.system-updates');
    Route::post('/check-system-updates', [SysNotificationController::class, 'check_system_updates'])->name('.check-system-updates');
    Route::get('/check-system-updates', [SysNotificationController::class, 'check_system_updates'])->name('.get-check-system-updates');
    Route::get('/system-updates-summary', [SysNotificationController::class, 'system_updates_summary'])->name('.check-system-summary');
    Route::post('/apply-system-updates', [SysNotificationController::class, 'apply_system_updates'])->name('.apply-system-updates');
  
    
    Route::prefix('scheduler')->name('.manage-notify-scheduler')->group(function(){

      Route::get('/', [SysNotifySchedulerController::class, 'index'])->name('.index');
    
      //TODO:: 
      Route::prefix('triggers')->name('.triggers')->group(function(){

        Route::get('sms/{scheduler}', [SysNotifyScheduleSmsTriggerController::class, 'index'])->name('.sms-index');

        //TODO::Route::prefix('/email', )
        Route::get('email/{scheduler}', [SysNotifyScheduleEmailTriggerController::class, 'index'])->name('.email-index');
        
        //TODO::Route::prefix('/notification', )
        Route::get('notification/{scheduler}', [SysNotifyScheduleNotificationTriggerController::class, 'index'])->name('.index');

      });
    
    });
  
  });
 

});