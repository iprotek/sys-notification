<?php

use Illuminate\Support\Facades\Route; 
use iProtek\SysNotification\Http\Controllers\SysNotificationController;

//Route::prefix('sms-sender')->name('sms-sender')->group(function(){
  //  Route::get('/', [SmsController::class, 'index'])->name('.index');
//});

Route::prefix('manage/sys-notification')->name('manage.sys-notification')->middleware(['auth'])->group(function(){
    Route::get('/test', [SysNotificationController::class, 'index'])->name('.test');
});