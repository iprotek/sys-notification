<?php

use Illuminate\Support\Facades\Route; 
use iProtek\SysNotification\Http\Controllers\SysNotificationController;

//Route::prefix('sms-sender')->name('sms-sender')->group(function(){
  //  Route::get('/', [SmsController::class, 'index'])->name('.index');
//});

Route::middleware(['web'])->group(function(){
 
  Route::middleware(['auth'])->prefix('manage/sys-notification')->name('manage.sys-notification')->group(function(){
    Route::get('/test', [SysNotificationController::class, 'index'])->name('.test');

  });

});