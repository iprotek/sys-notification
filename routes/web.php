<?php

use Illuminate\Support\Facades\Route; 
use iProtek\SysNotification\Http\Controllers\SysNotificationController;

//Route::prefix('sms-sender')->name('sms-sender')->group(function(){
  //  Route::get('/', [SmsController::class, 'index'])->name('.index');
//});

Route::middleware(['web'])->group(function(){
 
  Route::middleware(['auth'])->prefix('manage/sys-notification')->name('manage.sys-notification')->group(function(){
    Route::get('/test', [SysNotificationController::class, 'index'])->name('.test');
    Route::get('/', [SysNotificationController::class, 'index'])->name('.index');
    Route::get('/system-updates', [SysNotificationController::class, 'system_updates'])->name('.system-updates');
    Route::post('/check-system-updates', [SysNotificationController::class, 'check_system_updates'])->name('.check-system-updates');
    Route::post('/appy-system-updates', [SysNotificationController::class, 'apply_system_updates'])->name('.apply-system-updates');
  });

});