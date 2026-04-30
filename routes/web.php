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
    Route::get('/', [
      "uses"=>[SysNotificationController::class, 'index'],
      "description"=>"Update branches from centralize controls",
      "is_visible"=>false,
      "is_allow"=>false
    ])->name('.index');

    Route::get('/system-updates', [
      "uses"=>[SysNotificationController::class, 'system_updates'],
      "description"=>"Render system updates",
      "is_visible"=>false,
      "is_allow"=>false
    ])->name('.system-updates');

    Route::post('/check-system-updates', [
      "uses"=>[SysNotificationController::class, 'check_system_updates'],
      "description"=>"Check system updates",
      "is_visible"=>false,
      "is_allow"=>false
    ])->name('.check-system-updates');

    Route::get('/check-system-updates', [
      "uses"=>[SysNotificationController::class, 'check_system_updates'],
      "description"=>"Check system updates",
      "is_visible"=>false,
      "is_allow"=>false
    ])->name('.get-check-system-updates');

    Route::get('/system-updates-summary', [
      "uses"=>[SysNotificationController::class, 'system_updates_summary'],
      "description"=>"Preview system updates",
      "is_visible"=>false,
      "is_allow"=>false
    ])->name('.check-system-summary');

    Route::post('/apply-system-updates', [
      "uses"=>[SysNotificationController::class, 'apply_system_updates'],
      "description"=>"Apply system updates",
      "is_visible"=>false,
      "is_allow"=>false
    ])->name('.apply-system-updates');
  
    Route::get('clear', [
      "uses"=>[SysNotificationController::class, 'clear_notification'],
      "description"=>"Clear notification",
      "is_visible"=>false,
      "is_allow"=>false
    ])->name('.clear');
    
    Route::prefix('scheduler')->name('.manage-notify-scheduler')->group(function(){

      Route::get('/', [
        "uses"=>[SysNotifySchedulerController::class, 'index'],
        "description"=>"Scheduler Index View",
        "is_visible"=>false,
        "is_allow"=>false
      ])->name('.index');
    
      //TODO:: 
      Route::prefix('triggers')->name('.triggers')->group(function(){

        Route::get('sms/{scheduler}', [
          "uses"=>[SysNotifyScheduleSmsTriggerController::class, 'index'],
          "description"=>"Sms triggers in a scheduler",
          "is_visible"=>false,
          "is_allow"=>false
        ])->name('.sms-index');

        //TODO::Route::prefix('/email', )
        Route::get('email/{scheduler}', [
          "uses"=>[SysNotifyScheduleEmailTriggerController::class, 'index'],
          "description"=>"Email triggers in a scheduler",
          "is_visible"=>false,
          "is_allow"=>false
        ])->name('.email-index');
        
        //TODO::Route::prefix('/notification', )
        Route::get('notification/{scheduler}', [
          "uses"=>[SysNotifyScheduleNotificationTriggerController::class, 'index'],
          "description"=>"System notification triggers in a scheduler",
          "is_visible"=>false,
          "is_allow"=>false
        ])->name('.index');

      });
    
    });
  
  });
 

});